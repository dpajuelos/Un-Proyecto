<?php
namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Minera;
use App\Models\Persona;
use App\Models\Representante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function create()
    {
        return view('contacto');
    }

    public function searchPersona(Request $request)
    {
        try {
            $dni = $request->input('dni');

            if (!$dni) {
                return response()->json(['success' => false, 'message' => 'DNI requerido']);
            }

            $persona = Persona::where('dni', $dni)->first();

            if ($persona) {
                return response()->json([
                    'success' => true,
                    'persona' => [
                        'dni' => $persona->dni,
                        'nombres' => $persona->nombres,
                        'apellidos' => $persona->apellidos,
                        'telefono' => $persona->telefono,
                        'correo' => $persona->correo,
                    ]
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Persona no encontrada']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error en el servidor']);
        }
    }

    /**
     * Buscar datos de minera por RUC
     */
    public function searchMinera(Request $request)
    {
        $request->validate([
            'ruc' => 'required|string|size:11'
        ]);

        $ruc = $request->ruc;
        $minera = Minera::where('ruc', $ruc)->first();

        if ($minera) {
            // Buscar todos los representantes de esta minera
            $representantes = Representante::where('id_minera', $minera->id_minera)
                ->with('persona')
                ->get();

            $representantesData = $representantes->map(function ($rep) {
                return [
                    'id_rep' => $rep->id_rep,
                    'dni' => $rep->dni,
                    'cargo' => $rep->cargo,
                    'nombres' => $rep->persona->nombres,
                    'apellidos' => $rep->persona->apellidos,
                    'telefono' => $rep->persona->telefono,
                    'correo' => $rep->persona->correo,
                    'nombre_completo' => $rep->persona->nombres . ' ' . $rep->persona->apellidos
                ];
            });

            return response()->json([
                'found' => true,
                'data' => [
                    'id_minera' => $minera->id_minera,
                    'nombre_minera' => $minera->nombre_minera,
                    'direccion' => $minera->direccion,
                    'telefono_contacto' => $minera->telefono_contacto,
                    'correo_contacto' => $minera->correo_contacto
                ],
                'representantes' => $representantesData
            ]);
        }

        return response()->json(['found' => false]);
    }

    private function getPredefinedSlots($dayOfWeek)
    {
        // Lunes a Viernes (1-5): 6 horarios
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
            return [
                '08:00' => '8:00 AM',
                '10:00' => '10:00 AM',
                '12:00' => '12:00 PM',
                '14:00' => '2:00 PM',
                '16:00' => '4:00 PM',
                '18:00' => '6:00 PM'
            ];
        }

        // Sábado (6): 4 horarios
        if ($dayOfWeek == 6) {
            return [
                '09:00' => '9:00 AM',
                '10:30' => '10:30 AM',
                '12:00' => '12:00 PM',
                '13:00' => '1:00 PM'
            ];
        }

        // Domingo (0): Sin horarios
        return [];
    }

    /**
     * Verificar si un horario está ocupado
     */
    private function isSlotOccupied($fecha, $hora)
    {
        return Cita::where('fecha', $fecha)
            ->where('hora', $hora)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();
    }

    /**
     * Obtener horarios disponibles para una fecha específica
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $fecha = $request->fecha;
        $carbon = Carbon::parse($fecha);
        $dayOfWeek = $carbon->dayOfWeek;

        $predefinedSlots = $this->getPredefinedSlots($dayOfWeek);

        if (empty($predefinedSlots)) {
            return response()->json([
                'slots' => [],
                'message' => 'Domingos cerrado'
            ]);
        }

        $availableSlots = [];

        foreach ($predefinedSlots as $time => $display) {
            $isOccupied = $this->isSlotOccupied($fecha, $time);

            $availableSlots[] = [
                'time' => $time,
                'display' => $display,
                'available' => !$isOccupied,
                'status' => $isOccupied ? 'ocupado' : 'disponible'
            ];
        }

        return response()->json([
            'slots' => $availableSlots,
            'message' => 'Horarios disponibles'
        ]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|string'
        ]);

        $fecha = $request->fecha;
        $hora = $request->hora;

        $carbon = Carbon::parse($fecha);
        $dayOfWeek = $carbon->dayOfWeek;

        if ($dayOfWeek == 0) {
            return response()->json([
                'available' => false,
                'message' => 'Los domingos estamos cerrados.'
            ]);
        }

        $predefinedSlots = $this->getPredefinedSlots($dayOfWeek);

        if (!array_key_exists($hora, $predefinedSlots)) {
            return response()->json([
                'available' => false,
                'message' => 'Horario no válido. Por favor seleccione uno de los horarios disponibles.'
            ]);
        }

        if ($this->isSlotOccupied($fecha, $hora)) {
            return response()->json([
                'available' => false,
                'message' => 'Este horario ya está ocupado. Por favor seleccione otro.'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Horario disponible.'
        ]);
    }

    public function store(Request $request)
    {
        // Validaciones básicas primero
        $request->validate([
            'ruc' => 'required|string|size:11',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|string',
        ]);

        $carbon = Carbon::parse($request->fecha);
        $dayOfWeek = $carbon->dayOfWeek;

        // Validar día de la semana
        if ($dayOfWeek == 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Los domingos estamos cerrados. Por favor seleccione otra fecha.');
        }

        // Validar horario
        $predefinedSlots = $this->getPredefinedSlots($dayOfWeek);
        if (!array_key_exists($request->hora, $predefinedSlots)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Horario no válido. Por favor seleccione uno de los horarios disponibles.');
        }

        // Verificar disponibilidad
        if ($this->isSlotOccupied($request->fecha, $request->hora)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Este horario ya está ocupado. Por favor seleccione otro horario.');
        }

        try {
            DB::beginTransaction();

            // Buscar o crear minera
            $minera = Minera::where('ruc', $request->ruc)->first();
            if (!$minera) {
                // Validar campos de minera solo si es nueva
                $request->validate([
                    'nombre_minera' => 'required|string|max:255',
                ]);

                $minera = Minera::create([
                    'nombre_minera' => $request->nombre_minera,
                    'ruc' => $request->ruc,
                    'direccion' => $request->direccion,
                    'telefono_contacto' => $request->telefono_contacto,
                    'correo_contacto' => $request->correo_contacto,
                ]);
            }

            // Verificar si se seleccionó un representante existente
            if ($request->filled('representante_existente') && $request->representante_existente !== 'nuevo') {
                // Usar representante existente
                $representante = Representante::findOrFail($request->representante_existente);
            } else {
                // Crear nuevo representante
                $request->validate([
                    'dni' => 'required|string|size:8',
                    'nombres' => 'required|string|max:100',
                    'apellidos' => 'required|string|max:100',
                    'cargo' => 'required|string|max:100',
                ]);

                // Buscar o crear persona
                $persona = Persona::where('dni', $request->dni)->first();
                if (!$persona) {
                    $persona = Persona::create([
                        'dni' => $request->dni,
                        'nombres' => $request->nombres,
                        'apellidos' => $request->apellidos,
                        'telefono' => $request->telefono,
                        'correo' => $request->correo,
                    ]);
                }

                // Crear representante
                $representante = Representante::create([
                    'id_minera' => $minera->id_minera,
                    'dni' => $persona->dni,
                    'cargo' => $request->cargo,
                ]);
            }

            // Crear la cita
            $cita = Cita::create([
                'id_rep' => $representante->id_rep,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'descripcion' => $request->descripcion,
                'estado' => 'pendiente',
            ]);

            DB::commit();

            return redirect()->route('contacto')->with('success',
                'Su solicitud ha sido enviada exitosamente. Cita programada para el '
                    . $carbon->locale('es')->isoFormat('dddd, D [de] MMMM [a las] ')
                    . $predefinedSlots[$request->hora] . '. Nos pondremos en contacto para confirmar.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Hubo un error al procesar su solicitud. Por favor, inténtelo nuevamente. Error: ' . $e->getMessage());
        }
    }
}

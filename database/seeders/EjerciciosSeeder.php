<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Materia;
use App\Models\Tema;
use App\Models\Subtema;
use App\Models\Contenido;

class EjerciciosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ESTRUCTURA BÁSICA (Aseguramos que existan los padres)
        $materia = Materia::firstOrCreate(
            ['titulo' => 'Programación'],
            ['descripcion' => 'Fundamentos de lógica y código']
        );

        $tema = Tema::firstOrCreate(
            ['titulo' => 'Fundamentos', 'materia_id' => $materia->id],
            ['descripcion' => 'Conceptos básicos del lenguaje']
        );

        // 2. SUBTEMA 1: VARIABLES
        $subVariable = Subtema::firstOrCreate(
            ['titulo' => '¿Qué es una variable?', 'tema_id' => $tema->id],
            ['descripcion' => 'Definición y uso de memoria', 'informacion' => 'Una variable es un contenedor para almacenar datos...']
        );

        // LIMPIAMOS EJERCICIOS ANTERIORES DE ESTE SUBTEMA PARA NO DUPLICAR AL PROBAR
        DB::table('ejercicios')->where('subtema_id', $subVariable->id)->delete();

        // 2.5 AGREGAR CONTENIDO EDUCATIVO DEL SUBTEMA
        $this->crearContenidoVariable($subVariable);

        // 3. INSERTAR LOS 4 EJERCICIOS (2 Arrastrar, 2 Relacionar)
        $ejercicios = [
            // ==========================================
            // TIPO 1: ARRASTRAR (DRAG & DROP)
            // ==========================================
            
            // Ejercicio #1: Definición Básica
            [
                'subtema_id' => $subVariable->id,
                'titulo' => 'Concepto de Variable',
                'pregunta' => 'Completa la definición arrastrando la palabra correcta.',
                'tipo_interaccion' => 'arrastrar',
                'dificultad' => 'facil',
                'solucion' => 'memoria',
                'contenido_juego' => json_encode([
                    'frase_parte_1' => 'Una variable es un espacio en',
                    'espacio_vacio' => '__________', 
                    'frase_parte_2' => 'donde guardamos un valor.',
                    'opciones' => ['disco', 'memoria', 'nube']
                ]),
            ],

            // Ejercicio #2: Sintaxis de Asignación
            [
                'subtema_id' => $subVariable->id,
                'titulo' => 'El Operador de Asignación',
                'pregunta' => '¿Qué símbolo se usa para guardar un valor en una variable?',
                'tipo_interaccion' => 'arrastrar',
                'dificultad' => 'facil',
                'solucion' => '=',
                'contenido_juego' => json_encode([
                    'frase_parte_1' => 'En programación, usamos el signo',
                    'espacio_vacio' => '___', 
                    'frase_parte_2' => 'para asignar un valor a la variable.',
                    'opciones' => ['==', ':', '=']
                ]),
            ],

            // ==========================================
            // TIPO 2: RELACIONAR (MATCHING)
            // ==========================================

            // Ejercicio #3: Conceptos Clave
            [
                'subtema_id' => $subVariable->id,
                'titulo' => 'Conceptos Fundamentales',
                'pregunta' => 'Relaciona cada término con su característica principal.',
                'tipo_interaccion' => 'relacionar',
                'dificultad' => 'medio',
                'solucion' => 'relacionar_conceptos',
                'contenido_juego' => json_encode([
                    'pares' => [
                        ['origen' => 'Variable', 'destino' => 'Su valor cambia'],
                        ['origen' => 'Constante', 'destino' => 'Su valor es fijo'],
                        ['origen' => 'Nombre', 'destino' => 'Identificador'],
                        ['origen' => 'Tipo', 'destino' => 'Define el dato']
                    ]
                ]),
            ],

            // Ejercicio #4: Código vs Acción
            [
                'subtema_id' => $subVariable->id,
                'titulo' => 'Código vs Significado',
                'pregunta' => 'Une la línea de código con lo que está haciendo.',
                'tipo_interaccion' => 'relacionar',
                'dificultad' => 'dificil',
                'solucion' => 'relacionar_codigo',
                'contenido_juego' => json_encode([
                    'pares' => [
                        ['origen' => 'int x;', 'destino' => 'Declaración'],
                        ['origen' => 'x = 10;', 'destino' => 'Asignación'],
                        ['origen' => 'int x = 10;', 'destino' => 'Inicialización'],
                        ['origen' => 'x = x + 1;', 'destino' => 'Incremento']
                    ]
                ]),
            ],
        ];

        DB::table('ejercicios')->insert($ejercicios);
    }

    /**
     * Crear contenido educativo para el subtema de variables
     */
    private function crearContenidoVariable(Subtema $subVariable): void
    {
        // Limpiar contenidos anteriores para evitar duplicados
        DB::table('contenidos')->where('subtema_id', $subVariable->id)->delete();

        // Contenido 1: Concepto Fundamental
        Contenido::create([
            'subtema_id' => $subVariable->id,
            'titulo' => '¿Qué es una Variable?',
            'tipo_contenido' => 'TEXTO',
            'cuerpo' => <<<'HTML'
<h2>Concepto Fundamental</h2>
<p>Una <strong>variable</strong> es un espacio en la memoria del computador que almacena un valor que puede cambiar durante la ejecución de un programa.</p>

<h3>¿Por qué son importantes las variables?</h3>
<ul>
    <li><strong>Almacenar datos:</strong> Guardan información que el programa necesita usar</li>
    <li><strong>Manipular información:</strong> Permiten cambiar y procesar datos</li>
    <li><strong>Reutilizar valores:</strong> Podemos usar el mismo dato múltiples veces sin escribirlo nuevamente</li>
    <li><strong>Hacer programas dinámicos:</strong> El programa puede adaptarse a diferentes valores durante su ejecución</li>
</ul>

<h3>Analogía de la vida real</h3>
<p>Imagina una <strong>caja etiquetada</strong>:</p>
<ul>
    <li>La <strong>etiqueta</strong> es el nombre de la variable</li>
    <li>Lo que hay <strong>dentro de la caja</strong> es el valor almacenado</li>
    <li>El <strong>contenedor</strong> es la memoria del computador</li>
</ul>
<p>Así como puedes cambiar lo que hay en una caja física, también puedes cambiar el valor de una variable durante la ejecución del programa.</p>
HTML
        ]);

        // Contenido 2: Componentes de una Variable
        Contenido::create([
            'subtema_id' => $subVariable->id,
            'titulo' => 'Componentes de una Variable',
            'tipo_contenido' => 'TEXTO',
            'cuerpo' => <<<'HTML'
<h2>Partes Esenciales de una Variable</h2>

<h3>1. Nombre (Identificador)</h3>
<p>Es el nombre que le damos a la variable para referenciarnos a ella. Debe ser:</p>
<ul>
    <li>Único dentro del ámbito</li>
    <li>Descriptivo (que tenga sentido)</li>
    <li>Sin espacios</li>
    <li>Puede contener letras, números y guiones bajos</li>
    <li>No puede empezar con número</li>
</ul>
<p><strong>Ejemplos buenos:</strong> <code>edad</code>, <code>nombre_usuario</code>, <code>total_ventas</code></p>
<p><strong>Ejemplos malos:</strong> <code>x</code>, <code>a1b2c3</code>, <code>123valor</code></p>

<h3>2. Tipo de Dato</h3>
<p>Define qué clase de información puede guardar la variable:</p>
<ul>
    <li><strong>int (entero):</strong> números sin decimales: -5, 0, 100</li>
    <li><strong>float/double (decimal):</strong> números con decimales: 3.14, 2.5</li>
    <li><strong>string (texto):</strong> palabras y frases: "Hola", "Juan"</li>
    <li><strong>boolean (lógico):</strong> verdadero o falso: true, false</li>
    <li><strong>char (carácter):</strong> un solo carácter: 'A', '5', '@'</li>
</ul>

<h3>3. Valor</h3>
<p>Es el dato actual almacenado en la variable. Puede cambiar a lo largo del programa.</p>

<h3>Estructura Completa</h3>
<p><code>[Tipo] [Nombre] = [Valor];</code></p>
<p><strong>Ejemplo:</strong> <code>int edad = 18;</code></p>
<ul>
    <li><strong>Tipo:</strong> int</li>
    <li><strong>Nombre:</strong> edad</li>
    <li><strong>Valor:</strong> 18</li>
</ul>
HTML
        ]);

        // Contenido 3: Operaciones Básicas
        Contenido::create([
            'subtema_id' => $subVariable->id,
            'titulo' => 'Operaciones con Variables',
            'tipo_contenido' => 'TEXTO',
            'cuerpo' => <<<'HTML'
<h2>Operaciones Básicas</h2>

<h3>Declaración</h3>
<p>Crear una variable sin asignarle un valor inicial:</p>
<p><code>int numero;</code></p>
<p>La variable existe en memoria pero no sabemos qué valor tiene.</p>

<h3>Inicialización</h3>
<p>Crear una variable y asignarle un valor inicial:</p>
<p><code>int numero = 5;</code></p>

<h3>Asignación</h3>
<p>Cambiar el valor de una variable que ya existe:</p>
<p><code>numero = 10;</code></p>
<p>Ahora la variable <code>numero</code> vale 10, no 5.</p>

<h3>Lectura</h3>
<p>Usar el valor de una variable en operaciones:</p>
<pre><code>
int a = 5;
int b = 3;
int suma = a + b;  // suma = 8
System.out.println(a);  // Imprime: 5
</code></pre>

<h3>Operaciones Aritméticas</h3>
<ul>
    <li><code>+</code> (suma): <code>int c = a + b;</code></li>
    <li><code>-</code> (resta): <code>int c = a - b;</code></li>
    <li><code>*</code> (multiplicación): <code>int c = a * b;</code></li>
    <li><code>/</code> (división): <code>int c = a / b;</code></li>
    <li><code>%</code> (módulo/residuo): <code>int c = a % b;</code></li>
</ul>

<h3>Incremento y Decremento</h3>
<ul>
    <li><code>x++</code> (incrementa 1): <code>int x = 5; x++; // x = 6</code></li>
    <li><code>x--</code> (decrementa 1): <code>int x = 5; x--; // x = 4</code></li>
</ul>
HTML
        ]);

        // Contenido 4: Ejemplo Práctico
        Contenido::create([
            'subtema_id' => $subVariable->id,
            'titulo' => 'Ejemplo Práctico Completo',
            'tipo_contenido' => 'TEXTO',
            'cuerpo' => <<<'HTML'
<h2>Programa de Ejemplo: Calculadora Simple</h2>

<pre><code>
// Declaramos las variables
int numero1 = 10;
int numero2 = 5;
int suma;
int resta;
int multiplicacion;

// Realizamos operaciones
suma = numero1 + numero2;           // suma = 15
resta = numero1 - numero2;          // resta = 5
multiplicacion = numero1 * numero2; // multiplicacion = 50

// Mostramos resultados
System.out.println("Suma: " + suma);
System.out.println("Resta: " + resta);
System.out.println("Multiplicación: " + multiplicacion);

// Podemos cambiar los valores
numero1 = 20;
numero2 = 3;

suma = numero1 + numero2;  // Ahora suma = 23
System.out.println("Nueva suma: " + suma);
</code></pre>

<h3>Explicación Paso a Paso</h3>
<ol>
    <li>Creamos tres variables: <code>numero1</code>, <code>numero2</code>, <code>suma</code>, etc.</li>
    <li>Inicializamos <code>numero1</code> con 10 y <code>numero2</code> con 5</li>
    <li>La variable <code>suma</code> recibe el resultado de sumar los dos números</li>
    <li>Usamos <code>System.out.println()</code> para mostrar los valores</li>
    <li>Luego cambiamos los valores de <code>numero1</code> y <code>numero2</code></li>
    <li>Recalculamos la suma con los nuevos valores</li>
</ol>

<h3>¿Qué Aprendemos?</h3>
<ul>
    <li>Las variables pueden almacenar datos</li>
    <li>Podemos usar variables en operaciones matemáticas</li>
    <li>Los valores de las variables pueden cambiar durante la ejecución</li>
    <li>Podemos recalcular valores si las variables cambian</li>
</ul>
HTML
        ]);

        // Contenido 5: Reglas y Buenas Prácticas
        Contenido::create([
            'subtema_id' => $subVariable->id,
            'titulo' => 'Buenas Prácticas y Errores Comunes',
            'tipo_contenido' => 'TEXTO',
            'cuerpo' => <<<'HTML'
<h2>Buenas Prácticas</h2>

<h3>✓ Nombres Descriptivos</h3>
<p><strong>Bueno:</strong> <code>int edad_usuario = 25;</code></p>
<p><strong>Malo:</strong> <code>int x = 25;</code></p>
<p>Un nombre descriptivo hace el código más legible y fácil de entender.</p>

<h3>✓ Inicializar Variables</h3>
<p><strong>Bueno:</strong> <code>int contador = 0;</code></p>
<p><strong>Malo:</strong> <code>int contador;</code> (sin valor inicial)</p>
<p>Siempre inicializa tus variables para evitar valores indefinidos.</p>

<h3>✓ Usar el Tipo Correcto</h3>
<p><strong>Bueno:</strong> <code>double precio = 19.99;</code></p>
<p><strong>Malo:</strong> <code>int precio = 19;</code> (para un precio con decimales)</p>
<p>Elige el tipo de dato que mejor represente tu información.</p>

<h2>Errores Comunes</h2>

<h3>❌ Usar una variable sin declararla</h3>
<pre><code>
System.out.println(nombre);  // Error: nombre no fue declarada
</code></pre>

<h3>❌ Usar un nombre de variable con espacios</h3>
<pre><code>
int mi edad = 25;  // Error: sintaxis incorrecta
</code></pre>

<h3>❌ Asignar un valor del tipo incorrecto</h3>
<pre><code>
int edad = "veinticinco";  // Error: string a int
</code></pre>

<h3>❌ Usar un nombre de variable que ya existe</h3>
<pre><code>
int edad = 25;
int edad = 30;  // Error: edad ya fue declarada
</code></pre>

<h3>❌ Olvidar el punto y coma</h3>
<pre><code>
int numero = 5  // Error: falta punto y coma
</code></pre>

<h2>Resumen</h2>
<ul>
    <li>Siempre <strong>declara</strong> e <strong>inicializa</strong> tus variables</li>
    <li>Usa <strong>nombres descriptivos</strong> y en minúsculas con guiones bajos</li>
    <li>Elige el <strong>tipo de dato</strong> apropiado</li>
    <li>No olvides el <strong>punto y coma</strong> al final</li>
    <li>Las variables pueden <strong>cambiar de valor</strong> durante la ejecución</li>
</ul>
HTML
        ]);
    }
}
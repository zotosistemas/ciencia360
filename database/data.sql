INSERT INTO articulos (slug, titulo, resumen, contenido, imagen, tema, autor, fecha_publicacion, visitas)
VALUES
-- 🧠 Ciencia y Tecnología
('inteligencia-artificial-2025',
 'La inteligencia artificial en 2025: avances y desafíos éticos',
 'Descubre cómo la inteligencia artificial está transformando la educación, la medicina y el arte, y cuáles son los retos éticos más urgentes.',
 '<p>En 2025, la <strong>inteligencia artificial</strong> continúa su expansión a todos los sectores. Los modelos generativos permiten crear imágenes, música y texto con una calidad sin precedentes, mientras que los sistemas de diagnóstico médico logran precisiones superiores al 95%.</p>
 <p>Sin embargo, estos avances plantean grandes desafíos éticos. La falta de transparencia en los algoritmos y el uso de datos personales son temas de debate internacional. Organismos como la <em>Unesco</em> y la <em>OCDE</em> trabajan en marcos regulatorios para garantizar un desarrollo responsable de la IA.</p>
 <p>En el futuro inmediato, el reto será lograr una inteligencia artificial que complemente al ser humano, sin reemplazarlo.</p>',
 'ciencia-tecnologia-1.jpg',
 'ciencia-tecnologia',
 'Redacción Ciencia360',
 '2025-09-01 09:00:00',
 124),

-- 🌱 Medio Ambiente
('bosques-amazonicos-en-peligro',
 'Bosques amazónicos: guardianes del clima en peligro',
 'El Amazonas, pulmón del planeta, enfrenta una crisis sin precedentes. La deforestación y el cambio climático amenazan su equilibrio ecológico.',
 '<p>El <strong>bosque amazónico</strong> alberga más del 10% de la biodiversidad mundial. Sin embargo, la tala indiscriminada, los incendios forestales y la minería ilegal lo están llevando a un punto crítico.</p>
 <p>Según datos del <em>Instituto de Pesquisas da Amazônia</em>, en los últimos diez años se han perdido más de 40 millones de hectáreas. Esto no solo afecta a las especies nativas, sino también al equilibrio climático global, ya que el Amazonas actúa como un gigantesco regulador del dióxido de carbono.</p>
 <p>La conservación requiere políticas sostenibles, reforestación y una mayor conciencia ciudadana.</p>',
 'medio-ambiente-1.jpg',
 'medio-ambiente',
 'Redacción Ciencia360',
 '2025-08-20 10:30:00',
 98),

-- 🧬 Salud y Biología
('genetica-y-longevidad',
 'La genética detrás de la longevidad humana',
 'Nuevas investigaciones revelan genes clave relacionados con la regeneración celular y la prevención del envejecimiento.',
 '<p>Estudios recientes en <strong>biología molecular</strong> han identificado una serie de genes que influyen directamente en la longevidad. Entre ellos, los genes <em>SIRT1</em> y <em>FOXO3</em> desempeñan un papel esencial en la reparación del ADN y la resistencia al estrés oxidativo.</p>
 <p>El descubrimiento abre la puerta al desarrollo de terapias personalizadas para prolongar la vida saludable y prevenir enfermedades degenerativas.</p>
 <p>La biotecnología aplicada a la longevidad será uno de los campos más prometedores de la próxima década.</p>',
 'salud-biologia-1.jpg',
 'salud-biologia',
 'Dra. Valeria Rivas',
 '2025-09-10 08:45:00',
 74),

-- 🚀 Espacio y Futuro
('colonias-en-marte',
 'Colonias humanas en Marte: el siguiente paso de la exploración espacial',
 'Empresas privadas y agencias espaciales avanzan en los planes para establecer asentamientos sostenibles en el planeta rojo.',
 '<p>La <strong>exploración espacial</strong> vive una nueva era. Misiones como <em>Starship</em> de SpaceX y <em>Artemis</em> de la NASA buscan establecer colonias permanentes en la superficie de Marte.</p>
 <p>Los principales retos incluyen la producción de oxígeno, el cultivo de alimentos y la protección frente a la radiación. Sin embargo, la tecnología de impresión 3D y la inteligencia artificial están ofreciendo soluciones innovadoras.</p>
 <p>El futuro de la humanidad podría estar más allá de la Tierra, y Marte es el primer paso.</p>',
 'espacio-futuro-1.jpg',
 'espacio-futuro',
 'Ing. Diego Montes',
 '2025-08-30 11:00:00',
 156);

 /* Publicacion Prod */
INSERT INTO articulos (
  slug,
  titulo,
  resumen,
  contenido,
  imagen,
  tema,
  autor,
  fecha_publicacion,
  visitas
)
VALUES (
  'microrrobots-derrames-cerebrales-farmacos-dirigidos',
  'Microrrobots contra los derrames cerebrales: fármacos dirigidos al coágulo',
  'Investigadores exploran microrrobots capaces de transportar medicamento directamente a un coágulo en los vasos sanguíneos, con el objetivo de disolverlo de forma precisa y reducir efectos secundarios en el resto del organismo.',
  '<h2>Un nuevo enfoque frente a los derrames cerebrales</h2>
<p>Los derrames cerebrales de origen isquémico ocurren cuando un coágulo bloquea el flujo de sangre en una arteria del cerebro. Este tipo de accidente cerebrovascular es una de las principales causas de discapacidad y muerte en el mundo. El tiempo es crítico: cada minuto sin riego sanguíneo implica la pérdida de millones de neuronas, por lo que los médicos necesitan tratamientos rápidos y eficaces para restaurar la circulación.</p>

<p>En la práctica clínica actual, uno de los tratamientos más utilizados es la administración de fármacos trombolíticos por vía sistémica. Estas sustancias ayudan a disolver el coágulo, pero circulan por todo el cuerpo y pueden aumentar el riesgo de sangrados en otras zonas. Además, no siempre logran llegar a la zona exacta del trombo con la concentración necesaria, especialmente en vasos muy finos o de difícil acceso.</p>

<h2>Microrrobots que llevan el medicamento justo al coágulo</h2>
<p>Frente a estas limitaciones, varios grupos de investigación desarrollan microrrobots diseñados para transportar el fármaco directamente hasta el coágulo. Un avance destacado proviene de <a href=\"https://ethz.ch\" target=\"_blank\" rel=\"noopener noreferrer\">ETH Zurich</a>, donde se han creado cápsulas microrrobóticas con un recubrimiento de gel biodegradable capaz de cargar medicamento y nanopartículas magnéticas.</p>

<p>Estas cápsulas se inyectan en el torrente sanguíneo y se guían externamente mediante campos magnéticos. Gracias a las nanopartículas de óxido de hierro, los investigadores pueden dirigir el microrrobot a través de los vasos sanguíneos hasta la zona donde se encuentra el coágulo. Una vez allí, el recubrimiento de gel se degrada de forma controlada para liberar el fármaco directamente en el sitio afectado.</p>

<h2>Precisión, menos dosis sistémica y menos efectos adversos</h2>
<p>Este enfoque busca administrar el medicamento sobre el coágulo, reduciendo así la exposición del resto del organismo. En teoría, permitiría utilizar dosis menores de trombolítico, disminuyendo la probabilidad de complicaciones, especialmente hemorragias en órganos sensibles. La concentración de la acción sobre el problema es una estrategia que podría combinar eficacia con mayor seguridad para las personas.</p>

<p>Algunos prototipos también incluyen materiales detectables por rayos X u otras técnicas de imagen médica, permitiendo observar la navegación del microrrobot dentro del cuerpo. La combinación de guía magnética e imagen en tiempo real abre posibilidades para intervenciones más precisas, adaptadas a la anatomía de cada paciente.</p>

<h2>Estado actual de la investigación</h2>
<p>Por ahora, la mayoría de estos desarrollos sigue en fase experimental. Los microrrobots han demostrado su eficacia en modelos de vasos sanguíneos y en estudios con animales, donde lograron navegar por conductos complejos y liberar el fármaco localmente. Sin embargo, todavía quedan desafíos antes de que esta tecnología pueda utilizarse en humanos.</p>

<p>Entre las dificultades están la seguridad a largo plazo de los materiales, la fabricación a escala, la estandarización de técnicas de guía y la integración con equipos médicos en hospitales. También son necesarios ensayos clínicos que evalúen su verdadero impacto frente a los tratamientos actuales.</p>

<h2>Un vistazo al futuro</h2>
<p>La aplicación de microrrobots para administrar fármacos directamente en zonas específicas representa una transformación potencial en la medicina. En el caso de los derrames cerebrales, podría mejorar la recuperación y reducir secuelas al actuar con mayor rapidez sobre el coágulo. Asimismo, tecnologías similares podrían aplicarse en tumores, arterias obstruidas o tejidos de difícil acceso, permitiendo terapias más precisas.</p>

<p>Aunque todavía estamos en una etapa experimental, estos avances representan una nueva esperanza para los tratamientos basados en precisión. Aun así, reconocer los síntomas a tiempo y acudir a emergencias continúa siendo la herramienta más importante para proteger el cerebro.</p>

<h3>Fuentes y referencias</h3>
<ol>
  <li>
    ETH Zurich — “Microrobots finding their way”. Disponible en:
    <a href=\"https://ethz.ch/en/news-and-events/eth-news/news/2025/11/microrobots-finding-their-way.html\" target=\"_blank\" rel=\"noopener noreferrer\">ethz.ch</a>
  </li>
  <li>
    Universität Würzburg — “Microrobot delivers drugs directly to their site of action”. Disponible en:
    <a href=\"https://www.uni-wuerzburg.de/en/news-and-events/news/detail/news/microrobot-drugdelivery/\" target=\"_blank\" rel=\"noopener noreferrer\">uni-wuerzburg.de</a>
  </li>
  <li>
    Organización Mundial de la Salud (OMS) — Información sobre accidentes cerebrovasculares.  
    <a href=\"https://www.who.int\" target=\"_blank\" rel=\"noopener noreferrer\">who.int</a>
  </li>
  <li>
    Popular Science — “These tiny robots swim through your blood to fight strokes”.  
    <a href=\"https://www.popsci.com/health/microrrobot-blood-vessel-stroke/\" target=\"_blank\" rel=\"noopener noreferrer\">popsci.com</a>
  </li>
</ol>',
  'microrrobots-derrames-cerebrales.jpg',
  'salud-biologia',
  'Equipo Ciencia360',
  NOW(),
  0
);
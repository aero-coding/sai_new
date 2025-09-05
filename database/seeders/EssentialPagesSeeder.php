<?php

use App\Models\Page;
use Illuminate\Database\Seeder;

class EssentialPagesSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'page_type' => 'home',
                'slug' => [
                    'en' => 'home',
                    'es' => 'inicio'
                ],
                'title' => [
                    'en' => 'Homepage',
                    'es' => 'Página de Inicio'
                ],
                'excerpt' => [
                    'en' => 'Welcome to South American Initiative - Transforming lives across South America',
                    'es' => 'Bienvenido a South American Initiative - Transformando vidas en toda América del Sur'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/home-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/home-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'South American Initiative',
                        'hero_text' => 'We are a No Profit in Venezuela and South America with 30+ active Humanitarian Campaigns',
                        'help_subtitle' => 'Help Us Help Others',
                        'help_text' => 'Urgent Fundaraisings',
                        'sponsors_title' => 'Our Sponsors',
                        'about_mini_title' => 'About Us',
                        'about_subtitle' => 'What we do to help',
                        'image_about' => '',
                        'about_text_1' => 'South American Initiative is a U.S. based non - profit organization providing food and medical care for orphans , sick children , newborn infants , expectant mothers , and seniors , and food and shelter to abandoned dogs and zoo animals in Venezuela .',
                        'about_text_2' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.',
                        'values_title' => 'Our Values',
                        'values_card_1_title' => 'SAI is Determined to Rebuild South America.',
                        'values_card_1_text' => 'eres gei',
                        'image_values_card_1' => '',
                        'values_card_2_title' => 'Certified For US Donations & Tax Deduction',
                        'values_card_2_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt',
                        'image_values_card_2' => '',
                        'values_card_3_title' => 'Certified Budgeting & High Efficiency',
                        'values_card_3_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt',
                        'image_values_card_3' => '',
                        'certifications_title' => 'Our Certifications',
                        'news_title' => 'Articles & news from ongoing campaigns',
                        'news_side_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonymmy nibh euismod tincidunt at laoreet dolore magna aliqueam era volutpat.',
                        'news_link' => 'See all Articles >',
                        'testimonials_mini_title' => 'HELP PEOPLE IN NEED',
                        'testimonials_title' => 'REVIEWS FROM PEOPLE WE HELPED THANKS TO YOU',
                        'testimonials_side_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quam debitis dolorem similique repellat animi ullam saepe asperiores, ab consectetur eveniet vel nisi quisquam tenetur est omnis error. Provident, dolor.',
                        'testimonials_card_1_text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi harum deleniti aspernatur, natus nulla illo est sit cupiditate rerum mollitia! Esse, rerum. Enim vel quisquam, earum nemo quas provident labore!',
                        'image_testimonials_card_1' => '',
                        'testimonials_card_2_text' => 'Segundo testimonio: Quasi harum deleniti aspernatur, natus nulla illo est sit cupiditate rerum mollitia! Esse, rerum. Enim vel quisquam, earum nemo quas provident labore!',
                        'image_testimonials_card_2' => '',
                        'testimonials_card_3_text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi harum deleniti aspernatur, natus nulla illo est sit cupiditate rerum mollitia! Esse, rerum. Enim vel quisquam, earum nemo quas provident labore!  DONATE TO THIS CAMPAIGN > Testimonial Image 1 Profile picture Jane Smith Segundo testimonio: Quasi harum deleniti aspernatur, natus nulla illo est sit cupiditate rerum mollitia! Esse, rerum. Enim vel quisquam, earum nemo quas provident labore!  LEARN MORE > Testimonial Image 2 Profile picture Peter Jones Tercer testimonio: Natus nulla illo est sit cupiditate rerum mollitia! Esse, rerum. Enim vel quisquam, earum nemo quas provident labore! Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                        'image_testimonials_card_3' => '',
                        'numbers_title' => 'Our Numbers',
                        'numbers_text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores ducimus quia sunt aliquam aut incidunt ipsam vero placeat optio, vitae debitis voluptas nostrum, eveniet voluptate. Dignissimos id sunt explicabo vitae!',
                        'numbers_of_people_helped' => '25k+',
                        'numbers_of_educated_children' => '365',
                        'numbers_of_volunteers' => '230',
                        'numbers_of_served_meal' => '250k',
                        'call_to_action_title' => 'Help People In Need',
                        'call_to_action_text' => 'Start donating today, Make The Difference',
                        'call_to_action_card_1_title' => 'Start Volunteering',
                        'call_to_action_card_1_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.',
                        'call_to_action_card_2_title' => 'Become Sponsor',
                        'call_to_action_card_2_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.',
                        'call_to_action_card_3_title' => 'Download Annual Report',
                        'call_to_action_card_3_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.',
                        'image_call_to_action' => ''
                    ],
                    'es' => [
                        'h1_title' => 'South American Initiative',
                        'hero_text' => '',
                        'help_subtitle' => '',
                        'help_text' => '',
                        'sponsors_title' => '',
                        'about_mini_title' => '',
                        'about_subtitle' => '',
                        'image_about' => '',
                        'about_text_1' => '',
                        'about_text_2' => '',
                        'values_title' => '',
                        'values_card_1_title' => '',
                        'values_card_1_text' => '',
                        'image_values_card_1' => '',
                        'values_card_2_title' => '',
                        'values_card_2_text' => '',
                        'image_values_card_2' => '',
                        'values_card_3_title' => '',
                        'values_card_3_text' => '',
                        'image_values_card_3' => '',
                        'certifications_title' => '',
                        'news_title' => '',
                        'news_side_text' => '',
                        'news_link' => '',
                        'testimonials_mini_title' => '',
                        'testimonials_title' => '',
                        'testimonials_side_text' => '',
                        'testimonials_card_1_text' => '',
                        'image_testimonials_card_1' => '',
                        'testimonials_card_2_text' => '',
                        'image_testimonials_card_2' => '',
                        'testimonials_card_3_text' => '',
                        'image_testimonials_card_3' => '',
                        'numbers_title' => '',
                        'numbers_text' => '',
                        'numbers_of_people_helped' => '',
                        'numbers_of_educated_children' => '',
                        'numbers_of_volunteers' => '',
                        'numbers_of_served_meal' => '',
                        'call_to_action_title' => '',
                        'call_to_action_text' => '',
                        'call_to_action_card_1_title' => '',
                        'call_to_action_card_1_text' => '',
                        'call_to_action_card_2_title' => '',
                        'call_to_action_card_2_text' => '',
                        'call_to_action_card_3_title' => '',
                        'call_to_action_card_3_text' => '',
                        'image_call_to_action' => ''
                    ]
                ]
            ],
            [
                'page_type' => 'about',
                'slug' => [
                    'en' => 'about-us',
                    'es' => 'sobre-nosotros'
                ],
                'title' => [
                    'en' => 'About Us',
                    'es' => 'Sobre Nosotros'
                ],
                'excerpt' => [
                    'en' => 'Learn about our mission to transform lives in South America',
                    'es' => 'Conozca nuestra misión para transformar vidas en América del Sur'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/about-en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/about-es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/about-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/about-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'About Us',
                        'hero_text' => 'Your Donations Help Change The Future of South American Children',
                        'mission_title' => 'Our Mission',
                        'mission_text' => 'South American Initiative is a U.S. based non-profit organization providing food and medical care for orphans, sick children, newborn infants, expectant mothers, and seniors, and food and shelter to abandoned dogs and zoo animals in Venezuela.',
                        'floating_title' => 'Malnutrition #1 Cause of Illness & Death for Infants, Hospital Patients, Abandoned Pets & Zoo Animals',
                        'floating_text' => 'SAI provides food, medicine, and medical supplies to orphanages where parents have been forced to abandon their children because they can no longer afford to feed them. Malnutrition is the number one cause of illness and death for infants, children family pets, and zoo animals.',
                        'image_floating_1' => 'Image Floating 1',
                        'image_floating_2' => 'Image Floating 2',
                        'help_title' => 'Helping People & Animals in Their Deepest Time of Need',
                        'help_text' => 'SAI began operating in Venezuela providing humanitarian aid to hospitalized patients, orphaned children, the homeless, elderly who have been abandoned and forgotten in nursing homes and families who do not have shelter or food to eat.',
                        'certifications_title' => 'Our Certifications',
                        'sponsors_title' => 'Our Sponsors',
                        'values_card_1_title' => 'SAI is Determined to Rebuild South America.',
                        'values_card_1_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt',
                        'image_values_card_1' => 'Image Values Card 1',
                        'values_card_2_title' => 'Certified For US Donations & Tax Deduction',
                        'values_card_2_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt',
                        'image_values_card_2' => 'Image Values Card 2',
                        'values_card_3_title' => 'Certified Budgeting & High Efficiency',
                        'values_card_3_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt',
                        'image_values_card_3' => 'Image Values Card 3',
                        'numbers_title' => 'Our Numbers',
                        'numbers_text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores ducimus quia sunt aliquam aut incidunt ipsam vero placeat optio, vitae debitis voluptas nostrum, eveniet voluptate. Dignissimos id sunt explicabo vitae!',
                        'numbers_of_people_helped' => '25k+',
                        'numbers_of_educated_children' => '365',
                        'numbers_of_volunteers' => '230',
                        'numbers_of_served_meal' => '250k',
                        'reports_title' => 'Our Annual Reports',
                        'reports_text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
                        'image_report' => 'Image Report',
                        'call_to_action_card_1_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.',
                        'call_to_action_card_2_title' => 'Become Sponsor',
                        'call_to_action_card_2_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.',
                        'call_to_action_card_3_title' => 'Help More',
                        'call_to_action_card_3_text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.'
                    ],
                    'es' => [
                        'h1_title' => 'Sobre Nosotros',
                        'hero_text' => 'Sus donaciones ayudan a cambiar el futuro de los niños sudamericanos',
                        'mission_title' => 'Nuestra Misión',
                        'mission_text' => 'South American Initiative es una organización sin fines de lucro con sede en EE.UU. que brinda alimentos y atención médica a huérfanos, niños enfermos, recién nacidos, mujeres embarazadas y ancianos, y alimentos y refugio a perros abandonados y animales de zoológico en Venezuela.',
                        'floating_title' => 'La desnutrición es la causa número 1 de enfermedad y muerte para bebés, pacientes hospitalarios, mascotas abandonadas y animales de zoológico',
                        'floating_text' => 'SAI proporciona alimentos, medicinas y suministros médicos a orfanatos donde los padres se han visto obligados a abandonar a sus hijos porque ya no pueden alimentarlos.',
                        'image_floating_1' => 'Imagen Flotante 1',
                        'image_floating_2' => 'Imagen Flotante 2',
                        'help_title' => 'Ayudando a personas y animales en su momento de mayor necesidad',
                        'help_text' => 'SAI comenzó a operar en Venezuela brindando ayuda humanitaria a pacientes hospitalizados, niños huérfanos, personas sin hogar, ancianos abandonados y olvidados en hogares de ancianos y familias que no tienen refugio ni comida para comer.',
                        'certifications_title' => 'Nuestras Certificaciones',
                        'sponsors_title' => 'Nuestros Patrocinadores',
                        'values_card_1_title' => 'SAI está decidido a reconstruir Sudamérica.',
                        'values_card_1_text' => 'Texto de ejemplo sobre nuestros valores',
                        'image_values_card_1' => 'Imagen Valores 1',
                        'values_card_2_title' => 'Certificado para donaciones en EE.UU. y deducción de impuestos',
                        'values_card_2_text' => 'Texto de ejemplo sobre certificaciones',
                        'image_values_card_2' => 'Imagen Valores 2',
                        'values_card_3_title' => 'Presupuesto certificado y alta eficiencia',
                        'values_card_3_text' => 'Texto de ejemplo sobre eficiencia',
                        'image_values_card_3' => 'Imagen Valores 3',
                        'numbers_title' => 'Nuestros Números',
                        'numbers_text' => 'Impacto cuantificable de nuestro trabajo',
                        'numbers_of_people_helped' => '25k+',
                        'numbers_of_educated_children' => '365',
                        'numbers_of_volunteers' => '230',
                        'numbers_of_served_meal' => '250k',
                        'reports_title' => 'Nuestros Informes Anuales',
                        'reports_text' => 'Acceda a nuestros informes financieros y de impacto',
                        'image_report' => 'Imagen Informe',
                        'call_to_action_card_1_text' => 'Únete como voluntario y marca la diferencia',
                        'call_to_action_card_2_title' => 'Conviértete en Patrocinador',
                        'call_to_action_card_2_text' => 'Apoya nuestras causas de manera sostenible',
                        'call_to_action_card_3_title' => 'Ayuda a Más Personas',
                        'call_to_action_card_3_text' => 'Tu contribución amplía nuestro alcance'
                    ]
                ]
            ],
            [
                'page_type' => 'news',
                'slug' => [
                    'en' => 'news',
                    'es' => 'noticias'
                ],
                'title' => [
                    'en' => 'News & Updates',
                    'es' => 'Noticias y Actualizaciones'
                ],
                'excerpt' => [
                    'en' => 'Latest stories from our humanitarian campaigns',
                    'es' => 'Últimas historias de nuestras campañas humanitarias'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/news-en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/news-es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/news-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/news-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'News & Stories From The Continent',
                        'news_section_title' => 'Latest Updates',
                        'news_intro' => 'Stay informed about our ongoing projects and initiatives',
                        'featured_news_title' => 'Featured Story',
                        'featured_news_content' => 'Read about our recent relief efforts in Venezuela...'
                    ],
                    'es' => [
                        'h1_title' => 'Noticias e Historias del Continente',
                        'news_section_title' => 'Últimas Actualizaciones',
                        'news_intro' => 'Manténgase informado sobre nuestros proyectos e iniciativas en curso',
                        'featured_news_title' => 'Historia Destacada',
                        'featured_news_content' => 'Lea sobre nuestros recientes esfuerzos de ayuda en Venezuela...'
                    ]
                ]
            ],
            [
                'page_type' => 'contact',
                'slug' => [
                    'en' => 'contact-us',
                    'es' => 'contacto'
                ],
                'title' => [
                    'en' => 'Contact Us',
                    'es' => 'Contáctanos'
                ],
                'excerpt' => [
                    'en' => 'Get in touch with our team',
                    'es' => 'Comuníquese con nuestro equipo'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/contact-en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/contact-es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/contact-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/contact-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'Get In Touch',
                        'contact_text' => 'We\'d love to hear from you. Please fill out the form below.',
                        'form_title' => 'Send Us a Message',
                        'address' => '123 Charity St, Miami, FL 33101',
                        'email' => 'info@southamericaninitiative.org',
                        'phone' => '+1 (800) 123-4567',
                        'call_to_action_card_1_text' => 'For partnership inquiries',
                        'call_to_action_card_2_title' => 'Media Relations',
                        'call_to_action_card_2_text' => 'Press and media contacts',
                        'call_to_action_card_3_title' => 'Volunteer Opportunities',
                        'call_to_action_card_3_text' => 'Join our volunteer network'
                    ],
                    'es' => [
                        'h1_title' => 'Contáctenos',
                        'contact_text' => 'Nos encantaría saber de usted. Por favor complete el formulario a continuación.',
                        'form_title' => 'Envíenos un Mensaje',
                        'address' => '123 Calle Caridad, Miami, FL 33101',
                        'email' => 'info@iniciativasudamericana.org',
                        'phone' => '+1 (800) 123-4567',
                        'call_to_action_card_1_text' => 'Consultas sobre asociaciones',
                        'call_to_action_card_2_title' => 'Relaciones con Medios',
                        'call_to_action_card_2_text' => 'Contactos para prensa y medios',
                        'call_to_action_card_3_title' => 'Oportunidades de Voluntariado',
                        'call_to_action_card_3_text' => 'Únase a nuestra red de voluntarios'
                    ]
                ]
            ],
            [
                'page_type' => 'donate',
                'slug' => [
                    'en' => 'donate',
                    'es' => 'donar'
                ],
                'title' => [
                    'en' => 'Donate Now',
                    'es' => 'Done Ahora'
                ],
                'excerpt' => [
                    'en' => 'Support our humanitarian efforts',
                    'es' => 'Apoye nuestros esfuerzos humanitarios'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/main-en" width="100%" height="600px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/main-es" width="100%" height="600px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/donate-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/donate-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'Make a Difference Today',
                        'donation_options_title' => 'Ways to Give',
                        'one_time_donation' => 'One-Time Donation',
                        'monthly_donation' => 'Monthly Support',
                        'impact_text' => 'Your donation provides food, medicine and shelter to those in need'
                    ],
                    'es' => [
                        'h1_title' => 'Haga la Diferencia Hoy',
                        'donation_options_title' => 'Formas de Donar',
                        'one_time_donation' => 'Donación Única',
                        'monthly_donation' => 'Apoyo Mensual',
                        'impact_text' => 'Su donación proporciona alimentos, medicinas y refugio a los necesitados'
                    ]
                ]
            ],
            [
                'page_type' => 'crypto',
                'slug' => [
                    'en' => 'crypto-donations',
                    'es' => 'donaciones-cripto'
                ],
                'title' => [
                    'en' => 'Crypto Donations',
                    'es' => 'Donaciones en Criptomonedas'
                ],
                'excerpt' => [
                    'en' => 'Support us with cryptocurrency',
                    'es' => 'Apóyenos con criptomonedas'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/crypto-en" width="100%" height="600px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/crypto-es" width="100%" height="600px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/crypto-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/crypto-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'Donate with Cryptocurrency',
                        'intro_text' => 'We accept Bitcoin, Ethereum and other major cryptocurrencies',
                        'wallet_addresses_title' => 'Our Wallet Addresses',
                        'bitcoin_address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa',
                        'ethereum_address' => '0x742d35Cc6634C0532925a3b844Bc454e4438f44e'
                    ],
                    'es' => [
                        'h1_title' => 'Done con Criptomonedas',
                        'intro_text' => 'Aceptamos Bitcoin, Ethereum y otras criptomonedas principales',
                        'wallet_addresses_title' => 'Nuestras Direcciones de Billetera',
                        'bitcoin_address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa',
                        'ethereum_address' => '0x742d35Cc6634C0532925a3b844Bc454e4438f44e'
                    ]
                ]
            ],
            [
                'page_type' => 'explore',
                'slug' => [
                    'en' => 'explore-projects',
                    'es' => 'explorar-proyectos'
                ],
                'title' => [
                    'en' => 'Explore Projects',
                    'es' => 'Explorar Proyectos'
                ],
                'excerpt' => [
                    'en' => 'Discover our ongoing initiatives',
                    'es' => 'Descubra nuestras iniciativas en curso'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/explore-en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/explore-es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/explore-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/explore-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'Our Impactful Projects',
                        'project_filter_title' => 'Filter by Category',
                        'healthcare_title' => 'Healthcare Initiatives',
                        'education_title' => 'Education Programs',
                        'animal_welfare_title' => 'Animal Welfare'
                    ],
                    'es' => [
                        'h1_title' => 'Nuestros Proyectos de Impacto',
                        'project_filter_title' => 'Filtrar por Categoría',
                        'healthcare_title' => 'Iniciativas de Salud',
                        'education_title' => 'Programas Educativos',
                        'animal_welfare_title' => 'Bienestar Animal'
                    ]
                ]
            ],
            [
                'page_type' => 'double',
                'slug' => [
                    'en' => 'double-your-donation',
                    'es' => 'duplique-su-donacion'
                ],
                'title' => [
                    'en' => 'Double Your Impact',
                    'es' => 'Duplique Su Impacto'
                ],
                'excerpt' => [
                    'en' => 'Corporate matching gift programs',
                    'es' => 'Programas corporativos de donaciones equivalentes'
                ],
                'status' => 'active',
                'donation_iframe' => [
                    'en' => '<iframe src="https://donate.example.com/double-en" width="100%" height="500px"></iframe>',
                    'es' => '<iframe src="https://donate.example.com/double-es" width="100%" height="500px"></iframe>'
                ],
                'video_iframe' => [
                    'en' => '<iframe src="https://youtube.com/embed/double-en" width="100%" height="315"></iframe>',
                    'es' => '<iframe src="https://youtube.com/embed/double-es" width="100%" height="315"></iframe>'
                ],
                'content' => [
                    'en' => [
                        'h1_title' => 'Double Your Donation',
                        'intro_text' => 'Many companies offer matching gift programs to double employee donations',
                        'instructions_title' => 'How It Works',
                        'step1' => '1. Make your donation to SAI',
                        'step2' => '2. Request matching from your employer',
                        'step3' => '3. Your impact is doubled!'
                    ],
                    'es' => [
                        'h1_title' => 'Duplique Su Donación',
                        'intro_text' => 'Muchas empresas ofrecen programas de donaciones equivalentes para duplicar las donaciones de los empleados',
                        'instructions_title' => 'Cómo Funciona',
                        'step1' => '1. Realice su donación a SAI',
                        'step2' => '2. Solicite la donación equivalente a su empleador',
                        'step3' => '3. ¡Su impacto se duplica!'
                    ]
                ]
            ]
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug->en' => $pageData['slug']['en']],
                array_merge($pageData, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
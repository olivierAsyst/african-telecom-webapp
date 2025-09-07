<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $services = [
            [
                'title' => 'Services Technologiques',
                'description' => 'Fourniture d\'appareils technologiques aux utilisateurs avec support technique complet.',
                'icon' => '📱'
            ],
            [
                'title' => 'Sécurisation Réseaux',
                'description' => 'Sécurisation et maintenance des infrastructures des réseaux sans fil.',
                'icon' => '🔒'
            ],
            [
                'title' => 'Assistance Informatique',
                'description' => 'Support technique et assistance informatique pour tous vos besoins.',
                'icon' => '💻'
            ],
            [
                'title' => 'Incubateur',
                'description' => 'Accompagnement et incubation d\'autres établissements du domaine informatique.',
                'icon' => '🚀'
            ]
        ];

        $stats = [
            ['number' => '2021', 'label' => 'Année de création'],
            ['number' => '100+', 'label' => 'Projets réalisés'],
            ['number' => '50+', 'label' => 'Jeunes formés'],
            ['number' => '24/7', 'label' => 'Support disponible']
        ];

        return $this->render('home/index.html.twig', [
            'services' => $services,
            'stats' => $stats
        ]);
    }

    #[Route('/nos-activites', name: 'activities')]
    public function activities(): Response
    {
        $activities = [
            [
                'title' => 'Formation en Technologies',
                'description' => 'Formation des jeunes filles et garçons à la maîtrise de la manipulation informatique et des nouvelles technologies.',
                'image' => '🎓',
                'category' => 'Formation',
                'status' => 'En cours'
            ],
            [
                'title' => 'Maintenance Réseaux Sans Fil',
                'description' => 'Sécurisation et maintenance complète des infrastructures de réseaux sans fil pour entreprises.',
                'image' => '📡',
                'category' => 'Services',
                'status' => 'Actif'
            ],
            [
                'title' => 'Vente d\'Appareils Technologiques',
                'description' => 'Fourniture d\'appareils technologiques de qualité avec garantie et support technique.',
                'image' => '📱',
                'category' => 'Commerce',
                'status' => 'Actif'
            ],
            [
                'title' => 'Incubation de Startups',
                'description' => 'Accompagnement et incubation d\'établissements du domaine informatique pour favoriser l\'entrepreneuriat.',
                'image' => '🏢',
                'category' => 'Incubation',
                'status' => 'En développement'
            ],
            [
                'title' => 'Autonomisation Socio-économique',
                'description' => 'Initiatives pour renforcer l\'employabilité des jeunes et lutter contre le chômage.',
                'image' => '💼',
                'category' => 'Social',
                'status' => 'En cours'
            ],
            [
                'title' => 'Intégration des TIC',
                'description' => 'Facilitation de l\'intégration des nouvelles technologies de l\'information et de la communication.',
                'image' => '🌐',
                'category' => 'Innovation',
                'status' => 'Actif'
            ]
        ];

        return $this->render('activities/index.html.twig', [
            'activities' => $activities
        ]);
    }

    #[Route('/a-propos', name: 'about')]
    public function about(): Response
    {
        $timeline = [
            [
                'year' => '2021',
                'date' => '21 septembre 2021',
                'title' => 'Création d\'AFRICAN TELECOM',
                'description' => 'Enregistrement légal de la startup en République Démocratique du Congo.'
            ],
            [
                'year' => '2022',
                'date' => 'Début 2022',
                'title' => 'Lancement des premiers services',
                'description' => 'Début des activités de vente d\'appareils technologiques et d\'assistance informatique.'
            ],
            [
                'year' => '2023',
                'date' => 'Mi-2023',
                'title' => 'Expansion des formations',
                'description' => 'Lancement des programmes de formation pour les jeunes en technologies de l\'information.'
            ],
            [
                'year' => '2024',
                'date' => 'Aujourd\'hui',
                'title' => 'Développement de l\'incubateur',
                'description' => 'Mise en place de programmes d\'incubation pour startups informatiques.'
            ]
        ];

        $team = [
            [
                'name' => 'Direction Générale',
                'role' => 'Leadership & Vision',
                'description' => 'Pilotage stratégique et développement de la vision d\'entreprise.'
            ],
            [
                'name' => 'Équipe Technique',
                'role' => 'Développement & Support',
                'description' => 'Expertise technique et support client pour tous nos services.'
            ],
            [
                'name' => 'Équipe Formation',
                'role' => 'Éducation & Accompagnement',
                'description' => 'Formation des jeunes et accompagnement des entrepreneurs.'
            ]
        ];

        return $this->render('about/index.html.twig', [
            'timeline' => $timeline,
            'team' => $team
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        $contactInfo = [
            [
                'type' => 'Adresse',
                'value' => 'Uvira, République Démocratique du Congo, Est de la RDC',
                'icon' => '📍'
            ],
            [
                'type' => 'Téléphone',
                'value' => '+243 815 612 171',
                'icon' => '📞'
            ],
            [
                'type' => 'Email',
                'value' => 'info@africantelecom.org',
                'icon' => '✉️'
            ],
            [
                'type' => 'Horaires',
                'value' => 'Lundi - Samedi: 8h00 - 17h00',
                'icon' => '🕒'
            ]
        ];

        $services = [
            'Consultation technique',
            'Formation personnalisée',
            'Support maintenance',
            'Accompagnement startup',
            'Vente d\'équipements',
            'Sécurisation réseaux'
        ];

        return $this->render('contact/index.html.twig', [
            'contactInfo' => $contactInfo,
            'services' => $services
        ]);
    }
}

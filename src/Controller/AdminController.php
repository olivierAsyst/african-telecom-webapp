<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(SessionInterface $session): Response
    {
        $activities = $session->get('admin_activities', $this->getDefaultActivities());
        $stats = [
            'total_activities' => count($activities),
            'active_activities' => count(array_filter($activities, fn($a) => $a['status'] === 'Actif')),
            'pending_activities' => count(array_filter($activities, fn($a) => $a['status'] === 'En cours')),
            'development_activities' => count(array_filter($activities, fn($a) => $a['status'] === 'En développement'))
        ];

        return $this->render('admin/index.html.twig', [
            'activities' => $activities,
            'stats' => $stats
        ]);
    }

    #[Route('/activities', name: 'admin_activities')]
    public function activities(SessionInterface $session): Response
    {
        $activities = $session->get('admin_activities', $this->getDefaultActivities());
        
        return $this->render('admin/activities.html.twig', [
            'activities' => $activities
        ]);
    }

    #[Route('/activities/add', name: 'admin_activities_add')]
    public function addActivity(Request $request, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $activities = $session->get('admin_activities', $this->getDefaultActivities());
            
            $newActivity = [
                'id' => uniqid(),
                'title' => $request->request->get('title'),
                'description' => $request->request->get('description'),
                'category' => $request->request->get('category'),
                'status' => $request->request->get('status'),
                'image' => $request->request->get('image', '📋'),
                'created_at' => new \DateTime()
            ];
            
            $activities[] = $newActivity;
            $session->set('admin_activities', $activities);
            
            $this->addFlash('success', 'Activité ajoutée avec succès !');
            return $this->redirectToRoute('admin_activities');
        }

        $categories = ['Formation', 'Services', 'Commerce', 'Incubation', 'Social', 'Innovation'];
        $statuses = ['Actif', 'En cours', 'En développement', 'Suspendu'];
        $icons = ['🎓', '📡', '📱', '🏢', '💼', '🌐', '🔧', '💡', '📊', '🎯'];

        return $this->render('admin/add_activity.html.twig', [
            'categories' => $categories,
            'statuses' => $statuses,
            'icons' => $icons
        ]);
    }

    #[Route('/activities/{id}/edit', name: 'admin_activities_edit')]
    public function editActivity(string $id, Request $request, SessionInterface $session): Response
    {
        $activities = $session->get('admin_activities', $this->getDefaultActivities());
        $activity = null;
        $activityIndex = null;

        foreach ($activities as $index => $act) {
            if ($act['id'] === $id) {
                $activity = $act;
                $activityIndex = $index;
                break;
            }
        }

        if (!$activity) {
            $this->addFlash('error', 'Activité non trouvée !');
            return $this->redirectToRoute('admin_activities');
        }

        if ($request->isMethod('POST')) {
            $activities[$activityIndex] = [
                'id' => $id,
                'title' => $request->request->get('title'),
                'description' => $request->request->get('description'),
                'category' => $request->request->get('category'),
                'status' => $request->request->get('status'),
                'image' => $request->request->get('image'),
                'created_at' => $activity['created_at'] ?? new \DateTime(),
                'updated_at' => new \DateTime()
            ];
            
            $session->set('admin_activities', $activities);
            
            $this->addFlash('success', 'Activité modifiée avec succès !');
            return $this->redirectToRoute('admin_activities');
        }

        $categories = ['Formation', 'Services', 'Commerce', 'Incubation', 'Social', 'Innovation'];
        $statuses = ['Actif', 'En cours', 'En développement', 'Suspendu'];
        $icons = ['🎓', '📡', '📱', '🏢', '💼', '🌐', '🔧', '💡', '📊', '🎯'];

        return $this->render('admin/edit_activity.html.twig', [
            'activity' => $activity,
            'categories' => $categories,
            'statuses' => $statuses,
            'icons' => $icons
        ]);
    }

    #[Route('/activities/{id}/delete', name: 'admin_activities_delete')]
    public function deleteActivity(string $id, SessionInterface $session): Response
    {
        $activities = $session->get('admin_activities', $this->getDefaultActivities());
        
        $activities = array_filter($activities, fn($activity) => $activity['id'] !== $id);
        $session->set('admin_activities', array_values($activities));
        
        $this->addFlash('success', 'Activité supprimée avec succès !');
        return $this->redirectToRoute('admin_activities');
    }

    #[Route('/settings', name: 'admin_settings')]
    public function settings(Request $request, SessionInterface $session): Response
    {
        $settings = $session->get('admin_settings', [
            'site_name' => 'AFRICAN TELECOM',
            'site_description' => 'Startup informatique en République Démocratique du Congo',
            'contact_email' => 'contact@africantelecom.cd',
            'contact_phone' => '+243 XXX XXX XXX',
            'address' => 'République Démocratique du Congo, Est de la RDC'
        ]);

        if ($request->isMethod('POST')) {
            $settings = [
                'site_name' => $request->request->get('site_name'),
                'site_description' => $request->request->get('site_description'),
                'contact_email' => $request->request->get('contact_email'),
                'contact_phone' => $request->request->get('contact_phone'),
                'address' => $request->request->get('address')
            ];
            
            $session->set('admin_settings', $settings);
            $this->addFlash('success', 'Paramètres sauvegardés avec succès !');
        }

        return $this->render('admin/settings.html.twig', [
            'settings' => $settings
        ]);
    }

    private function getDefaultActivities(): array
    {
        return [
            [
                'id' => 'act1',
                'title' => 'Formation en Technologies',
                'description' => 'Formation des jeunes filles et garçons à la maîtrise de la manipulation informatique et des nouvelles technologies.',
                'image' => '🎓',
                'category' => 'Formation',
                'status' => 'En cours',
                'created_at' => new \DateTime('2023-01-15')
            ],
            [
                'id' => 'act2',
                'title' => 'Maintenance Réseaux Sans Fil',
                'description' => 'Sécurisation et maintenance complète des infrastructures de réseaux sans fil pour entreprises.',
                'image' => '📡',
                'category' => 'Services',
                'status' => 'Actif',
                'created_at' => new \DateTime('2022-06-10')
            ],
            [
                'id' => 'act3',
                'title' => 'Vente d\'Appareils Technologiques',
                'description' => 'Fourniture d\'appareils technologiques de qualité avec garantie et support technique.',
                'image' => '📱',
                'category' => 'Commerce',
                'status' => 'Actif',
                'created_at' => new \DateTime('2022-03-20')
            ],
            [
                'id' => 'act4',
                'title' => 'Incubation de Startups',
                'description' => 'Accompagnement et incubation d\'établissements du domaine informatique pour favoriser l\'entrepreneuriat.',
                'image' => '🏢',
                'category' => 'Incubation',
                'status' => 'En développement',
                'created_at' => new \DateTime('2023-09-01')
            ],
            [
                'id' => 'act5',
                'title' => 'Autonomisation Socio-économique',
                'description' => 'Initiatives pour renforcer l\'employabilité des jeunes et lutter contre le chômage.',
                'image' => '💼',
                'category' => 'Social',
                'status' => 'En cours',
                'created_at' => new \DateTime('2023-05-12')
            ],
            [
                'id' => 'act6',
                'title' => 'Intégration des TIC',
                'description' => 'Facilitation de l\'intégration des nouvelles technologies de l\'information et de la communication.',
                'image' => '🌐',
                'category' => 'Innovation',
                'status' => 'Actif',
                'created_at' => new \DateTime('2023-02-28')
            ]
        ];
    }
}

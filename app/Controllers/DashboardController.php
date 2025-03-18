<?php
        namespace App\Controllers;

        use App\Core\Controller;

        class DashboardController extends Controller
        {
            public function index()
            {
                $this->requireLogin();
                // Utilisation de la méthode view pour charger la vue
                $this->view('dashboard/index-view');
            }

            public function apiGetUserData($params)
            {
                if (!$this->isLoggedIn()) {
                    return ['success' => false, 'message' => 'Non autorisé'];
                }

                // Simuler des données utilisateur
                return [
                    'success' => true,
                    'userData' => [
                        'username' => $_SESSION['username'],
                        'lastLogin' => date('Y-m-d H:i:s'),
                        'role' => 'utilisateur'
                    ]
                ];
            }
        }
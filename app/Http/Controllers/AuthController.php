<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Permission;
use App\Models\Token;

class AuthController extends Controller
{
    private $userModel;
    private $permissionModel;
    private $tokenModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->permissionModel = new Permission();
        $this->tokenModel = new Token();
    }

    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin()
    {
        // Laisser l'utilisateur accéder à la page login même s'il est déjà connecté
        // Il pourra choisir de se déconnecter ou rester connecté
        return view('login');
    }


    public function login(Request $request)
    {
        // Log::info('Tonga soa ato amin\'ny login method vaovao');
        // Si déjà connecté, rediriger vers le dashboard
        if (User::isAuthenticated()) {
            return redirect('/page_default')
                ->with('info', 'Vous êtes déjà connecté.');
        }

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Tentative de connexion', ['login' => $request->login]);

        try {
            // Authentification
            $authResult = $this->userModel->authenticate($request->login, $request->password);
            //$authResult = false;
            if ($authResult) {

                $token = $authResult;
                
                $userId = $this->tokenModel->getUserIdByToken($token);

                Log::info('ID utilisateur récupéré', ['user_id' => $userId]);
                
                if ($userId == null) {
                    
                    $adminToken = $this->tokenModel->getAdminToken();
                    
                    // Si vous voulez implémenter la recherche par login, décommentez :
                    if ($adminToken) {

                        $un_user =  $this->userModel->getUserByLoginFromList($request->login);
                        
                        $userId = $un_user ? $un_user['id'] : null;

                        if ($userId) {
                            $this->tokenModel->insertUserToken($userId, $token);
                        }
                    }
                }

                
                if ($userId) {

                    Log::info('Récupération des permissions', ['user_id' => $userId]);
                    
                    // Récupérer les permissions
                    //$permissions = $this->permissionModel->getUserPermissions($userId);
                    $permissions = $this->permissionModel->getUserPermissions($userId);

                    $userData = $this->tokenModel->getUserWithAdminToken($userId, $token);
                
                    
                    //Stocker en session
                    Session::put([
                        'user' => [
                            'login' => $request->login,
                            'authenticated' => true,
                            'id' => $userId,
                            'full_name' => $userData['user']['firstname'] . ' ' . $userData['user']['lastname'],
                            'firstname' => $userData['user']['firstname'] ?? '',
                            'lastname' => $userData['user']['lastname'] ?? '',
                            'email' => $userData['user']['email'] ?? '',
                            'photo' => $userData['user']['photo'] ?? null,
                            'role' => $userData['user']['job'] ?? 'Commercial'
                        ],
                        'dolibarr_token' => $token,//$authResult['token'],
                        //'auth_message' => $authResult['message'],
                        'user_permissions' => $permissions
                    ]);

                    //Log::info('Token', ['token' => substr($authResult['token'], 0, 20) . '...']); // CORRIGÉ
                    Log::info('Permissions count', ['count' => count($permissions['all_permissions'] ?? [])]); // CORRIGÉ
                    Log::info('Modules', ['modules' => array_keys($permissions['by_module'] ?? [])]); // CORRIGÉ

                    return redirect('/page_default')
                        ->with('success', 'Bienvenue sur la plateforme de gestion de projets PHAOS.');

                } else {
                    Log::info('Erreur récupération ID', ['message' => 'Impossible de récupérer l\'ID utilisateur pour: ' . $request->login]); // CORRIGÉ
                    Log::error('Erreur récupération ID', ['login' => $request->login]); // CORRIGÉ
                    return back()
                        ->withInput()
                        ->withErrors(['error' => ' Veuillez contacter l\'administrateur s\'il vous plaît']);
                }

            } else {

                Log::info('Authentification échouée', ['message' => 'Authentification échouée pour: ' . $request->login]); // CORRIGÉ
                Log::warning('Authentification échouée', ['login' => $request->login]); // CORRIGÉ
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Nom d’utilisateur ou mot de passe incorrect. Veuillez vérifier vos informations et réessayer.']);
            }

        } catch (\Exception $e) {

            Log::info('Erreur connexion', ['message' => 'Erreur connexion pour ' . $request->login . ': ' . $e->getMessage()]); // CORRIGÉ
            Log::error('Erreur connexion', [ // CORRIGÉ
                'login' => $request->login,
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur de connexion au serveur: ' . $e->getMessage()]);
        }
    }


    /**
     * Déconnexion
     */
    public function logout()
    {

        // $userLogin = Session::get('user.login', 'Unknown');
        // Log::info('Déconnexion de:', ['user' => $userLogin]);
        
        // Vider complètement la session
        Session::flush();
        
        // Ou spécifiquement les données d'authentification :
        // Session::forget(['user', 'dolibarr_token', 'user_permissions', 'auth_message']);
        
        // Log::info('Session vidée, redirection vers login');
        
        return redirect('/login')
            ->with('success', 'Déconnexion réussie !');
    }

    /**
     * Tableau de bord
     */
    public function dashboard()
    {
        if (!User::isAuthenticated()) {
            return redirect('/login')
                ->withErrors(['error' => 'Veuillez vous connecter']);
        }

        $user = Session::get('user');
        $token = Session::get('dolibarr_token');
        $permissions = User::getPermissions();

        Log::info('Accès dashboard pour: ' . $user['login']);

        return view('dashboard', compact('user', 'token', 'permissions'));
    }
}
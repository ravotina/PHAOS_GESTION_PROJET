<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    
    /**
     * Récupérer les notifications de l'utilisateur connecté
     */
    public function index()
    {
        $userId = session('user.id');
        
        if (!$userId) {
            return response()->json(['notifications' => []]);
        }
        
        // Récupérer les 20 dernières notifications
        $notifications = Notification::where('id_utilisateur', $userId)
            ->orderBy('date_heur_notification', 'desc')
            ->limit(20)
            ->get();
        
        // Organiser par période
        $groupedNotifications = $this->groupByPeriod($notifications);
        
        // Compter les notifications non lues
        $unreadCount = Notification::where('id_utilisateur', $userId)
            ->where('etat', 0)
            ->count();
        
        return response()->json([
            'notifications' => $groupedNotifications,
            'unread_count' => $unreadCount,
            'total_count' => $notifications->count()
        ]);
        
    }
    
    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $userId = session('user.id');
        
        $notification = Notification::where('id', $id)
            ->where('id_utilisateur', $userId)
            ->first();
        
        if ($notification) {
            $notification->etat = 1;
            $notification->save();
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $userId = session('user.id');
        
        Notification::where('id_utilisateur', $userId)
            ->where('etat', 0)
            ->update(['etat' => 1]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Grouper les notifications par période (Aujourd'hui, Hier, Cette semaine)
     */
    private function groupByPeriod($notifications)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfWeek = Carbon::now()->startOfWeek();
        
        $groups = [
            'today' => ['title' => 'AUJOURD\'HUI', 'notifications' => []],
            'yesterday' => ['title' => 'HIER', 'notifications' => []],
            'this_week' => ['title' => 'CETTE SEMAINE', 'notifications' => []],
            'older' => ['title' => 'PLUS ANCIENNES', 'notifications' => []]
        ];
        
        foreach ($notifications as $notification) {
            $date = Carbon::parse($notification->date_heur_notification);
            
            if ($date->isToday()) {
                $groups['today']['notifications'][] = $this->formatNotification($notification);
            } elseif ($date->isYesterday()) {
                $groups['yesterday']['notifications'][] = $this->formatNotification($notification);
            } elseif ($date->greaterThanOrEqualTo($startOfWeek)) {
                $groups['this_week']['notifications'][] = $this->formatNotification($notification);
            } else {
                $groups['older']['notifications'][] = $this->formatNotification($notification);
            }
        }
        
        // Filtrer les groupes vides
        $filteredGroups = [];
        foreach ($groups as $key => $group) {
            if (!empty($group['notifications'])) {
                $filteredGroups[$key] = $group;
            }
        }
        
        return $filteredGroups;
    }
    

    /**
     * Formater une notification pour l'affichage
     */
    private function formatNotification($notification)
    {
        // Déterminer l'icône en fonction du type
        $icon = $this->getNotificationIcon($notification->titre, $notification->table_source);
        
        // Formater le temps écoulé
        $timeAgo = $this->getTimeAgo($notification->date_heur_notification);
        
        return [
            'id' => $notification->id,
            'icon' => $icon,
            'icon_class' => $this->getIconClass($notification->titre),
            'title' => $notification->titre,
            'message' => $notification->description,
            'time' => $timeAgo,
            'date_formatted' => Carbon::parse($notification->date_heur_notification)->format('d/m'),
            'is_unread' => $notification->etat == 0,
            'source' => $notification->table_source,
            'date_debut' => $notification->date_debu,
            'date_fin' => $notification->date_fin,
            'action_url' => $this->getActionUrl($notification)
        ];
    }
    
    /**
     * Obtenir l'icône appropriée
     */
    private function getNotificationIcon($title, $source)
    {
        $title = strtolower($title);
        
        if (strpos($title, 'tâche') !== false || strpos($title, 'calendrier') !== false) {
            return 'bi-calendar-check';
        } elseif (strpos($title, 'validation') !== false || strpos($title, 'validé') !== false) {
            return 'bi-check-circle';
        } elseif (strpos($title, 'modification') !== false || strpos($title, 'ajustement') !== false) {
            return 'bi-arrow-clockwise';
        } elseif (strpos($title, 'retard') !== false || strpos($title, 'urgence') !== false) {
            return 'bi-clock';
        } elseif (strpos($title, 'refusé') !== false || strpos($title, 'rejeté') !== false) {
            return 'bi-x-circle';
        } elseif (strpos($title, 'budget') !== false || strpos($title, 'financier') !== false) {
            return 'bi-currency-euro';
        } elseif ($source === 'calendrier_preparation') {
            return 'bi-calendar-event';
        }
        
        return 'bi-bell';
    }
    
    /**
     * Obtenir la classe CSS de l'icône
     */
    private function getIconClass($title)
    {
        $title = strtolower($title);
        
        if (strpos($title, 'tâche') !== false) {
            return 'icon-calendar';
        } elseif (strpos($title, 'validation') !== false) {
            return 'icon-validated';
        } elseif (strpos($title, 'modification') !== false) {
            return 'icon-modification';
        } elseif (strpos($title, 'retard') !== false) {
            return 'icon-delayed';
        } elseif (strpos($title, 'refusé') !== false) {
            return 'icon-rejected';
        } elseif (strpos($title, 'budget') !== false) {
            return 'icon-finance';
        }
        
        return 'icon-default';
    }
    
    /**
     * Obtenir le temps écoulé formaté
     */
    private function getTimeAgo($date)
    {
        $now = Carbon::now();
        $date = Carbon::parse($date);
        $diff = $date->diff($now);
        
        if ($diff->days == 0) {
            if ($diff->h == 0) {
                if ($diff->i < 1) return 'à l\'instant';
                return 'il y a ' . $diff->i . ' min';
            }
            return 'il y a ' . $diff->h . ' h';
        } elseif ($diff->days == 1) {
            return 'hier';
        } elseif ($diff->days < 7) {
            return 'il y a ' . $diff->days . ' jours';
        } elseif ($diff->days < 30) {
            return 'il y a ' . floor($diff->days / 7) . ' sem';
        }
        
        return $date->format('d/m/Y');
    }
    
    /**
     * Obtenir l'URL d'action pour la notification
     */
    private function getActionUrl($notification)
    {
        if ($notification->table_source === 'calendrier_preparation') {
            return '/calendrier';
        }
        
        return '#';
    }



    // ... méthodes existantes (index, markAsRead, markAllAsRead) ...
    
    /**
     * Récupérer seulement les compteurs de notifications
     */
    public function count()
    {
        $userId = session('user.id');
        
        if (!$userId) {
            return response()->json([
                'unread_count' => 0,
                'total_count' => 0
            ]);
        }
        
        $unreadCount = Notification::where('id_utilisateur', $userId)
            ->where('etat', 0)
            ->count();
            
        $totalCount = Notification::where('id_utilisateur', $userId)
            ->count();
        
        return response()->json([
            'unread_count' => $unreadCount,
            'total_count' => $totalCount
        ]);
    }
    
    // ... autres méthodes existantes ...

    /**
 * Récupérer les tâches (notifications) pour l'utilisateur connecté avec pagination
 */
public function getTasks(Request $request)
{
    $userId = session('user.id');
    
    if (!$userId) {
        return response()->json([
            'tasks' => [],
            'has_more' => false
        ]);
    }
    
    // Pagination
    $page = $request->get('page', 1);
    $perPage = 20;
    $offset = ($page - 1) * $perPage;
    
    // Base query
    $query = Notification::where('id_utilisateur', $userId);
    
    // Appliquer les filtres
    $filter = $request->get('filter', 'all');
    
    switch ($filter) {
        case 'unread':
            $query->where('etat', 0);
            break;
        case 'read':
            $query->where('etat', 1);
            break;
        case 'today':
            $query->whereDate('date_heur_notification', Carbon::today());
            break;
        case 'week':
            $query->whereBetween('date_heur_notification', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
            break;
        case 'older':
            $query->where('date_heur_notification', '<', Carbon::now()->subWeek());
            break;
    }
    
    // Compter le total pour ce filtre
    $total = $query->count();
    
    // Récupérer les notifications avec pagination
    $notifications = $query->orderBy('date_heur_notification', 'desc')
        ->skip($offset)
        ->take($perPage + 1) // Prendre une de plus pour savoir s'il y en a d'autres
        ->get();
    
    // Vérifier s'il y a plus de notifications
    $hasMore = $notifications->count() > $perPage;
    if ($hasMore) {
        $notifications->pop(); // Retirer l'élément supplémentaire
    }
    
    // Formater les notifications pour l'affichage
    $formattedTasks = $notifications->map(function ($notification) {
        return $this->formatTaskForDisplay($notification);
    });
    
    return response()->json([
        'tasks' => $formattedTasks,
        'has_more' => $hasMore,
        'total' => $total,
        'current_page' => $page,
        'per_page' => $perPage
    ]);
}

/**
 * Formater une notification pour l'affichage dans le tableau des tâches
 */
private function formatTaskForDisplay($notification)
{
    // Icône selon le type
    $icon = $this->getNotificationIcon($notification->titre, $notification->table_source);
    
    // Temps écoulé
    $timeAgo = $this->getTimeAgo($notification->date_heur_notification);
    
    // Format de date
    $dateFormatted = Carbon::parse($notification->date_heur_notification)->format('d/m/Y H:i');
    
    // URL d'action
    $actionUrl = '#';
    if ($notification->table_source === 'calendrier_preparation') {
        $actionUrl = '/calendrier';
    }
    
    // Source lisible
    $source = $this->getReadableSource($notification->table_source);
    
    return [
        'id' => $notification->id,
        'icon' => $icon,
        'title' => $notification->titre,
        'message' => $notification->description,
        'time' => $timeAgo,
        'date_formatted' => $dateFormatted,
        'is_unread' => $notification->etat == 0,
        'source' => $notification->table_source,
        'source_readable' => $source,
        'date_debut' => $notification->date_debu,
        'date_fin' => $notification->date_fin,
        'action_url' => $actionUrl
    ];
}

/**
 * Obtenir un nom lisible pour la source
 */
private function getReadableSource($source)
{
    $sources = [
        'calendrier_preparation' => 'Calendrier',
        'calendrier' => 'Calendrier',
        'audit' => 'Audit',
        'projet' => 'Projet',
        'validation' => 'Validation'
    ];
    
    return $sources[$source] ?? $source;
}
    
    // private function getTimeAgo($date)
    // {
    //     $now = Carbon::now();
    //     $date = Carbon::parse($date);
    //     $diff = $date->diff($now);
        
    //     if ($diff->days == 0) {
    //         if ($diff->h == 0) {
    //             if ($diff->i < 1) return 'à l\'instant';
    //             return 'il y a ' . $diff->i . ' min';
    //         }
    //         return 'il y a ' . $diff->h . ' h';
    //     } elseif ($diff->days == 1) {
    //         return 'hier';
    //     } elseif ($diff->days < 7) {
    //         return 'il y a ' . $diff->days . ' jours';
    //     }
        
    //     return $date->format('d/m/Y');
    // }
}
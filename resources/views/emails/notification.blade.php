<!DOCTYPE html>
<html>
<head>
    <title>Notification Phaos</title>
    <style type="text/css">
        /* RÉINITIALISATION POUR EMAIL */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            width: 100% !important;
        }
        
        /* CONTAINER PRINCIPAL - TABLE POUR EMAIL */
        .container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        /* HEADER - STYLE SIMPLE POUR EMAIL */
        .header {
            background: #000000;
            background: linear-gradient(to right, #000000, #b15d15);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        
        .logo-container {
            margin-bottom: 15px;
        }
        
        .logo {
            max-height: 60px;
            width: auto;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
            margin: 10px 0;
        }
        
        .header h2 {
            font-size: 20px;
            font-weight: normal;
            margin: 0;
            color: #ffffff;
        }
        
        /* CONTENU PRINCIPAL */
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        
        /* SALUTATION */
        .greeting {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #b15d15;
        }
        
        .greeting h3 {
            color: #000000;
            margin: 0 0 10px 0;
            font-size: 22px;
            font-weight: bold;
        }
        
        .greeting p {
            color: #666666;
            margin: 0;
            font-size: 16px;
        }
        
        /* CARTE ÉVÉNEMENT - TABLE POUR COMPATIBILITÉ */
        .event-card {
            background-color: #f8f9fa;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #b15d15;
        }
        
        .event-card h4 {
            color: #000000;
            margin: 0 0 15px 0;
            font-size: 20px;
            font-weight: bold;
        }
        
        /* TABLE POUR LA COMPATIBILITÉ */
        .event-detail {
            margin-bottom: 12px;
        }
        
        .event-detail strong {
            color: #000000;
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .event-detail span {
            color: #333333;
        }
        
        /* BADGE TEMPS - INLINE STYLE */
        .time-badge {
            display: inline-block;
            background-color: rgba(177, 93, 21, 0.1);
            color: #b15d15;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            margin: 5px 10px 5px 0;
            font-size: 14px;
            border: 1px solid rgba(177, 93, 21, 0.2);
        }
        
        /* SECTION TÂCHE */
        .task-section {
            background-color: #fdf6f0;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #b15d15;
        }
        
        .task-section h5 {
            color: #000000;
            margin: 0 0 12px 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .task-description {
            color: #333333;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
            padding: 12px;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
        }
        
        /* SECTION MESSAGE */
        .message-section {
            background-color: #f0f8ff;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #0056b3;
        }
        
        .message-section h5 {
            color: #0056b3;
            margin: 0 0 12px 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .message-content {
            color: #004085;
            font-style: italic;
            margin: 0;
            padding-left: 10px;
            border-left: 3px solid #0056b3;
        }
        
        /* BOUTON D'ACTION - TABLE POUR COMPATIBILITÉ */
        .action-button {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn {
            display: inline-block;
            background: #b15d15;
            background: linear-gradient(to right, #000000, #b15d15);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            border: none;
        }
        
        /* FOOTER */
        .footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #eeeeee;
        }
        
        .footer-logo {
            max-height: 30px;
            width: auto;
            margin-bottom: 15px;
        }
        
        .footer p {
            color: #666666;
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .copyright {
            color: #999999;
            font-size: 13px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eeeeee;
        }
        
        /* RESPONSIVE POUR EMAIL */
        @media screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
            
            .content {
                padding: 20px !important;
            }
            
            .event-detail strong {
                display: block;
                width: auto;
                margin-bottom: 5px;
            }
            
            .btn {
                display: block;
                width: 100%;
                max-width: 280px;
                margin: 0 auto;
            }
        }
        
        /* STYLES INLINE POUR GMAIL */
        .fallback-font {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>


<body style="margin: 0; padding: 0; background-color: #f5f5f5;">
    <!--[if mso]>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px;">
    <![endif]-->
    
    <div class="container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <!-- HEADER AVEC LOGO -->
        <div class="header" style="background: #000000; background: linear-gradient(to right, #000000, #b15d15); color: #ffffff; padding: 30px 20px; text-align: center;">
            <div class="logo-container" style="margin-bottom: 15px;">
                <!-- Logo en base64 pour éviter les problèmes de chargement -->
                 <!-- @if(file_exists(public_path('assets/img/logo-phaos.webp')))
                <img src="https://i.postimg.cc/7hwq2YK4/logo-phaos.webp"
                alt="PHAOS" 
                width="120"
                height="60"
                style="display: block; max-width: 120px; height: auto; margin: 0 auto; border: 0;">
                @else -->

                <div class="company-name" style="font-size: 28px; font-weight: bold; color: #ffffff; margin: 10px 0;">PHAOS</div>

                <!-- @endif -->
            </div>
            <h2 style="font-size: 20px; font-weight: normal; margin: 0; color: #ffffff;">Nouvelle Notification de Tâche</h2>
        </div>
        
        <!-- CONTENU PRINCIPAL -->
        <div class="content" style="padding: 30px; background-color: #ffffff;">
            <!-- SALUTATION -->
            <div class="greeting" style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #b15d15;">
                <h3 style="color: #000000; margin: 0 0 10px 0; font-size: 22px; font-weight: bold;">
                    Bonjour {{ $utilisateur['firstname'] ?? ($utilisateur->firstname ?? 'Utilisateur') }},
                </h3>
                <p style="color: #666666; margin: 0; font-size: 16px;">
                    Une nouvelle tâche vous a été assignée dans l'application Phaos.
                </p>
            </div>
            
            <!-- CARTE ÉVÉNEMENT -->
            <div class="event-card" style="background-color: #f8f9fa; padding: 25px; margin: 25px 0; border-left: 5px solid #b15d15;">
                <h4 style="color: #000000; margin: 0 0 15px 0; font-size: 20px; font-weight: bold;">
                    {{ $event->title }}
                </h4>
                
                @if($event->decription)
                <div class="event-detail" style="margin-bottom: 12px;">
                    <strong style="color: #000000; font-weight: bold; display: inline-block; width: 120px;">Description :</strong>
                    <span style="color: #333333;">{{ $event->decription }}</span>
                </div>
                @endif
                
                @if($event->date_debut)
                <div class="event-detail" style="margin-bottom: 12px;">
                    <strong style="color: #000000; font-weight: bold; display: inline-block; width: 120px;">Date de début :</strong>
                    <span class="time-badge" style="display: inline-block; background-color: rgba(177, 93, 21, 0.1); color: #b15d15; padding: 6px 12px; border-radius: 20px; font-weight: bold; margin: 5px 10px 5px 0; font-size: 14px; border: 1px solid rgba(177, 93, 21, 0.2);">
                        {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y à H:i') }}
                    </span>
                </div>
                @endif
                
                @if($event->date_fin)
                <div class="event-detail" style="margin-bottom: 12px;">
                    <strong style="color: #000000; font-weight: bold; display: inline-block; width: 120px;">Date de fin :</strong>
                    <span class="time-badge" style="display: inline-block; background-color: rgba(177, 93, 21, 0.1); color: #b15d15; padding: 6px 12px; border-radius: 20px; font-weight: bold; margin: 5px 10px 5px 0; font-size: 14px; border: 1px solid rgba(177, 93, 21, 0.2);">
                        {{ \Carbon\Carbon::parse($event->date_fin)->format('d/m/Y à H:i') }}
                    </span>
                </div>
                @endif
            </div>
            
            <!-- SECTION DÉTAILS DE LA TÂCHE -->
            @if($utilisateurs_concerner && $utilisateurs_concerner->description_tache)
            <div class="task-section" style="background-color: #fdf6f0; padding: 20px; margin: 20px 0; border-left: 4px solid #b15d15;">
                <h5 style="color: #000000; margin: 0 0 12px 0; font-size: 18px; font-weight: bold;">
                    Détails de votre mission
                </h5>
                <p class="task-description" style="color: #333333; font-size: 15px; line-height: 1.6; margin: 0; padding: 12px; background-color: #ffffff; border: 1px solid #eeeeee;">
                    {{ $utilisateurs_concerner->description_tache }}
                </p>
            </div>
            @endif

            
            <!-- BOUTON D'ACTION -->
            <div class="action-button" style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/') }}" class="btn" style="display: inline-block; background: #b15d15; background: linear-gradient(to right, #000000, #b15d15); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 50px; font-weight: bold; font-size: 16px; text-align: center; border: none;">
                    Accéder à l'application Phaos
                </a>
                <p style="margin-top: 12px; color: #666666; font-size: 14px;">
                    Connectez-vous pour plus de détails et pour mettre à jour l'état de la tâche.
                </p>
            </div>
        </div>
        
        <!-- FOOTER -->
        <div class="footer" style="background-color: #f8f9fa; padding: 25px; text-align: center; border-top: 1px solid #eeeeee;">
            <!-- @if(file_exists(public_path('assets/img/logo-phaos.webp')))
                <img src="{{ config('app.url') }}/assets/img/logo-phaos.webp" alt="Logo Phaos" class="footer-logo" style="max-height: 30px; width: auto; margin-bottom: 15px;">
            @endif -->
            
            <!-- <p style="color: #666666; margin: 8px 0; font-size: 14px; line-height: 1.5;">
                Cet email a été envoyé automatiquement par le système de notification Phaos.
            </p>
            <p style="color: #666666; margin: 8px 0; font-size: 14px; line-height: 1.5;">
                Merci de ne pas répondre à cet email.
            </p> -->

            <p class="copyright" style="color: #999999; font-size: 13px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eeeeee;">
                &copy; {{ date('Y') }} Phaos - Tous droits réservés.<br>
                <small>Gestion de projet Phaos</small>
            </p>
        </div>
    </div>

    <!--[if mso]>
            </td>
        </tr>
    </table>
    <![endif]-->
</body>
</html>
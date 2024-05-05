<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Periode;
use App\Models\RelevePlan;
use App\Models\Releveur;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    //Traitement de l'authentification
    public function index(Request $request)
    {

        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {

            return view('welcome');
        }
        $user = Auth::user();
        // you are already logged in... so check for if you are an admin user..
        if ($request->path() == 'login' || $request->path() == '/') {
            return redirect('/releves');
        }

        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request)
    {
        // decode the stringfy json into a real json
        $permission = json_decode($user->role->permission);

        $hasPermission = false;
        if (!$permission)
            return view('welcome');
        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        }

        return view('notfound');

    }

    // Traitement du logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Ajouter un releveur
    public function addReleveur(Request $request)
    {
        // validate request 
        // if this doesnt work it returns a json data

        // Validation part
        $messages = [
            'serialNumber.required' => 'Le numéro de série est requis.',
            'serialNumber.unique' => 'Le numéro de série doit être unique pour chaque releveur.',
            'serialNumber.regex' => 'Le numéro de série doit être de la forme RXYZ.',
            'iconImage.required' => 'L\'image du releveur est requise.',
            'fullName.required' => 'Le nom complet du releveur est requis.',
            'fullName.unique' => 'Le nom complet est déjà utilisé.',
            'fullName.regex' => 'Le nom complet du releveur doit contenir au moins trois lettres pour le prénom et le nom, séparés par un espace , de forme Nom Prénom.',
            'birthday.required' => 'La date de naissance du releveur est requise.',
            'birthday.date' => 'La date de naissance doit être une date valide.',
            'birthday.before' => 'Le releveur doit être âgé de 18 ans ou plus.',
            'birthday.after' => 'Le releveur doit être âgé de moins de 65 ans.',
            'email.required' => 'Le champ e-mail est requis.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        ];

        $this->validate($request, [
            'serialNumber' => [
                'required',
                Rule::unique('releveurs', 'serialNumber'),
                'regex:/^R\d{3}$/',
            ],
            'iconImage' => 'required',
            'fullName' => [
                'required',
                Rule::unique('releveurs', 'fullName'),
                'regex:/^[a-zA-Z]{3,}\s[a-zA-Z]{3,}$/',
            ],

            'birthday' => [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'after:' . Carbon::now()->subYears(65)->format('Y-m-d'),
            ],
            'email' => 'bail|required|email|unique:releveurs',
        ], $messages);
        return Releveur::create([
            'serialNumber' => $request->serialNumber,
            'iconImage' => $request->iconImage,
            'fullName' => $request->fullName,
            'birthday' => $request->birthday,
            'email' => $request->email,
        ]);
    }
    public function editReleveur(Request $request)
    {
        // validate request 
        // if this doesnt wrok it returns a json data
        $releveur = Releveur::findOrFail($request->id);

        // check if any values have been updated
        if (
            $releveur->serialNumber == $request->serialNumber &&
            $releveur->fullName == $request->fullName &&
            $releveur->birthday == $request->birthday &&
            $releveur->email == $request->email &&
            $releveur->iconImage == $request->iconImage
        ) {
            // no changes were made
            return response()->json(['message' => 'Pas de changement effectué'], 203);
        }
        $messages = [
            'serialNumber.required' => 'Le numéro de série est requis.',
            'serialNumber.unique' => 'Le numéro de série doit être unique pour chaque releveur.',
            'serialNumber.regex' => 'Le numéro de série doit être de la forme RXYZ.',
            'iconImage.required' => 'L\'image du releveur est requise.',
            'fullName.required' => 'Le nom complet du releveur est requis.',
            'fullName.unique' => 'Le nom complet est déjà utilisé.',
            'fullName.regex' => 'Le nom complet du releveur doit contenir au moins trois lettres pour le prénom et le nom, séparés par un espace , de forme Nom Prénom.',
            'birthday.required' => 'La date de naissance du releveur est requise.',
            'birthday.date' => 'La date de naissance doit être une date valide.',
            'birthday.before' => 'Le releveur doit être âgé de 18 ans ou plus.',
            'birthday.after' => 'Le releveur doit être âgé de moins de 65 ans.',
            'email.required' => 'Le champ e-mail est requis.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
        ];

        $this->validate($request, [
            'id' => 'required',
            'serialNumber' => [
                'required',
                Rule::unique('releveurs', 'serialNumber')->ignore($request->id),
                'regex:/^R\d{3}$/',
            ],
            'iconImage' => 'required',
            'fullName' => [
                'required',
                Rule::unique('releveurs', 'fullName')->ignore($request->id),
                'regex:/^[a-zA-Z]{3,}\s[a-zA-Z]{3,}$/',
            ],


            'birthday' => [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'after:' . Carbon::now()->subYears(65)->format('Y-m-d'),
            ],
            'email' => "bail|required|email|unique:releveurs,email," . $request->id,
        ], $messages);
        return Releveur::whereId($request->id)->update(([
            'serialNumber' => $request->serialNumber,
            'fullName' => $request->fullName,
            'iconImage' => $request->iconImage,
            'birthday' => $request->birthday,
            'email' => $request->email,
        ]));
    }
    public function deleteReleveur(Request $request)
    {
        $releveur = Releveur::findOrFail($request->id);

        // Supprimer l'image du serveur
        $this->deleteFileFromServer($releveur->iconImage);

        // Supprimer tous les plans du releveur
        $releveur->relevePlan()->delete();

        // Supprimer le releveur
        $releveur->delete();

        return response()->json(['success' => true]);
    }


    public function getReleveur(Request $request)
    {
        return Releveur::orderBy('id', 'desc')->paginate($request->total);
    }
    public function addPlan(Request $request)
    {
        // validate request 
        // if this doesn't work, it returns a json data
        $messages = [
            'releveur.required' => 'Le releveur est requis.',
            'date_releve.required' => 'La date de relève est requise.',
            'date_releve.date' => 'La date de relève doit être une date valide.',
            'date_releve.after' => 'La date de relève doit être postérieure à la date actuelle.',
            'num_tournee_debut.required' => 'Le numéro de tournée de début est requis.',
            'num_tournee_debut.regex' => 'Le numéro de tournée de début doit être de la forme XXX XXX XXX désignant Zone Maison Etage.',
            'num_tournee_fin.required' => 'Le numéro de tournée de fin est requis.',
            'num_tournee_fin.regex' => 'Le numéro de tournée de fin doit être de la forme XXX XXX XXX désignant Zone Maison Etage.',
            'ordre_lecture.required' => 'L\'ordre de lecture est requis.',
            'ordre_lecture.regex' => 'L\'ordre de lecture doit être de la forme "nombre1 nombre2 ...".',
            'temps_execution_jours.required' => 'Le temps d\'exécution en jours est requis.',
            'temps_execution_jours.integer' => 'Le temps d\'exécution en jours doit être un nombre entier.',
            'temps_execution_jours.min' => 'Le temps d\'exécution en jours doit être au moins égal au nombre de paquets.',
            'temps_execution_jours.max' => 'Le temps d\'exécution en jours ne doit pas dépasser 1,5 fois le nombre de paquets.',
        ];

        $this->validate($request, [
            'releveur' => [
                'required',
                // function ($attribute, $value, $fail) use ($request) {
                //     // calcul de la date fin de ce planning 
                //     $dateFinPrev = Carbon::parse($request->date_releve)->addDays($request->temps_execution_jours - 1);

                //     $autresPlannings = RelevePlan::where('releveur', $request->releveur)
                //         ->get();

                //     // Vérifier s'il y a un conflit de planning avec les autres plannings attribués au releveur
                //     foreach ($autresPlannings as $autrePlanning) {

                //         // la date fin de l'autre planning selon la boucle
                //         $autreDateFinPrev = Carbon::parse($autrePlanning->date_releve)->addDays($autrePlanning->temps_execution_jours - 1);

                //         if (
                //             ($request->date_releve >= $autrePlanning->date_releve && $request->date_releve <= $autreDateFinPrev) ||
                //             ($dateFinPrev >= $autrePlanning->date_releve && $dateFinPrev <= $autreDateFinPrev)
                //         ) {
                //             $fail('Le releveur souhaité est déjà assigné à un autre planning sur cette période.');
                //             return;
                //         }
                //     }
                // }
            ],
            'date_releve' => [
                'required',
                'date',
                'after:today',
                function ($attribute, $value, $fail) use ($request) {
                    $dateFin = Carbon::parse($request->date_releve)->addDays($request->temps_execution_jours - 1);
                    $dateFinDuMois = Carbon::parse($request->date_releve)->endOfMonth();
                    if ($dateFin > $dateFinDuMois) {
                        $fail("la fin de la relève doit être dans le mois courant de " . Carbon::now()->format('F'));
                    }
                    if (Carbon::parse($value)->startOfMonth()->ne(Carbon::now()->startOfMonth())) {
                        $fail("la relève doit commencer dans le mois courant de " . Carbon::now()->format('m'));

                    }
                }
            ],

            'num_tournee_debut' => [
                'required',
                'regex:/^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $suffixe_debut = substr($request->input('num_tournee_debut'), 8);

                    if ($suffixe_debut > 30) {
                        $fail("Le nombre des étages pour un seul foyer ne doit pas dépasser 30.");
                    }
                },
            ],
            'num_tournee_fin' => [
                'required',
                'regex:/^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/',
                function ($attribute, $value, $fail) use ($request) {
                    // validation de la valeur de num_tournee_fin
                    $prefix_debut = substr($request->input('num_tournee_debut'), 0, 3);
                    $prefix_fin = substr($request->input('num_tournee_fin'), 0, 3);
                    $seffixe_fin_h = substr($request->input('num_tournee_fin'), 8);

                    if ($seffixe_fin_h > 30) {
                        $fail("Le nombre des étages pour un seul foyer ne doit pas dépasser 30.");
                    }
                    if ($prefix_debut !== $prefix_fin) {
                        $fail("Le préfixe du numéro de tournée de fin (numéro de la zone) doit être identique à celui du numéro de tournée de début.");
                    }

                    $suffixe_debut = substr($request->input('num_tournee_debut'), 4);
                    $suffixe_fin = substr($request->input('num_tournee_fin'), 4);
                    if ($suffixe_debut >= $suffixe_fin) {
                        $fail("Le suffixe du numéro de tournée de fin doit être supérieur à celui du numéro de tournée de début.");
                    }

                    $difference_yyy = intval($suffixe_fin) - intval($suffixe_debut);
                    if ($difference_yyy > 500) {
                        $fail("le nombre de maison/appartement pour un seul planning doit être au maximum de 500.");
                    }
                    if ($difference_yyy < 50) {
                        $fail("un planning doit au moins contenir 50 maisons/appartements");
                    }


                    $plannings = RelevePlan::where('id', '<>', $request->id)->get();
                    foreach ($plannings as $planning) {
                        $planning_debut = $planning->num_tournee_debut;
                        $planning_fin = $planning->num_tournee_fin;

                        if ($request->input('num_tournee_debut') >= $planning_debut && $request->input('num_tournee_fin') <= $planning_fin) {
                            // Case 1: The range of tour numbers is included in another planning
                            $fail("La plage de numéro de tournée est incluse dans un autre planning.");
                            break;
                        }

                        if ($request->input('num_tournee_debut') <= $planning_debut && $request->input('num_tournee_fin') >= $planning_fin) {
                            // Case 2: The planning contains an existing planning
                            $fail("Le planning contient un planning existant.");
                            break;
                        }

                        if ($request->input('num_tournee_debut') >= $planning_debut && $request->input('num_tournee_debut') <= $planning_fin) {
                            // Case 3: The beginning of the planning overlaps with an existing planning
                            $fail("Le début du planning chevauche un planning existant.");
                            break;
                        }

                        if ($request->input('num_tournee_fin') >= $planning_debut && $request->input('num_tournee_fin') <= $planning_fin) {
                            // Case 4: The end of the planning overlaps with an existing planning
                            $fail("La fin du planning chevauche un planning existant.");
                            break;
                        }
                    }

                },
            ],

            'ordre_lecture' => [
                'required',
                'regex:/^\d+(\s+\d+)*$/',
                function ($attribute, $value, $fail) use ($request) {
                    $numTourneeDebut = $request->num_tournee_debut;
                    $numTourneeDebutParts = explode(' ', $numTourneeDebut);
                    $numTourneePrefix = $numTourneeDebutParts[0];
                    $numTourneeFinParts = explode(' ', $request->num_tournee_fin);
                    $numTourneeFinPrefix = $numTourneeFinParts[0];
                    $numbers = explode(' ', $request->ordre_lecture);
                    $count = count($numbers);

                    if (($numTourneeDebutParts[1] == $numTourneeFinParts[1]) && $count !== 1) {
                        $fail("l'ordre de lecture doit avoir un seul paquet car on est dans la meme maison");
                    }

                    if ($count != count(array_unique($numbers))) {
                        $counted = array_count_values($numbers);
                        foreach ($counted as $number => $occurrences) {
                            if ($occurrences > 1) {
                                $fail("les paquets doivent être uniques ");
                                break;
                            }
                        }
                    }
                    if ($count > 5) {
                        $fail("Le total des paquets ne doit pas dépasser 5 paquets pour un seul planning.");
                    }
                },
                function ($attribute, $value, $fail) {
                    $numbers = array_unique(explode(' ', $value));
                    $count = count($numbers);
                    foreach ($numbers as $number) {
                        if ($number <= 0) {
                            $fail($attribute . 'ne doit pas contenir des nombres négatifs ou nuls');
                        }
                    }
                },

            ],

            'temps_execution_jours' => [
                'required',
                'integer',
                'min:' . floor(count(explode(' ', $request->ordre_lecture))),
                'max:' . floor(count(explode(' ', $request->ordre_lecture)) * 1.5),
                function ($attribute, $value, $fail) use ($request) {
                    $releveur = $request->releveur;
                    $plannings = RelevePlan::where('releveur', $releveur)->get();
                    $total_temps_execution_jours = 0;
                    foreach ($plannings as $planning) {
                        $total_temps_execution_jours += $planning->temps_execution_jours;
                    }
                    if ($total_temps_execution_jours + $value > 30) {
                        $fail("La somme des temps d'exécution en jours pour ce relevéur ne doit pas dépasser 30 jours.");
                    }
                },
                function ($attribute, $value, $fail) use ($request) {
                    $planId = $request->input('id');
                    $dateReleve = $request->input('date_releve');
                    $newTempsExecutionJours = (int) $value;

                    // Retrieve existing plans for the same releveur
                    $existingPlans = RelevePlan::where('releveur', $request->input('releveur'))
                        ->where('id', '!=', $planId)
                        ->get();

                    // Calculate the new end date based on the modified temps_execution_jours value
                    $newDateFin = date('Y-m-d', strtotime($dateReleve . ' +' . ($newTempsExecutionJours - 1) . ' days'));

                    // Check for overlapping dates with other plans
                    foreach ($existingPlans as $existingPlan) {
                        $existingDateReleve = $existingPlan->date_releve;
                        $existingDateFin = date('Y-m-d', strtotime($existingDateReleve . ' +' . ($existingPlan->temps_execution_jours - 1) . ' days'));

                        if (($dateReleve <= $existingDateFin && $newDateFin >= $existingDateReleve) || ($dateReleve >= $existingDateReleve && $newDateFin <= $existingDateFin) || ($dateReleve <= $existingDateReleve && $newDateFin >= $existingDateFin)) {
                            $fail('Le releveur souhaité est déjà assigné à un autre planning sur cette période.');
                            break;
                        }
                    }
                },
            ]
        ], $messages);

        $orderLecture = $request->ordre_lecture;
        $orders = explode(' ', $orderLecture);
        $totalNumber = count($orders) * 112;


        $periode = Periode::findOrFail(1);

        // create the new plan with the "acteur" field set to the current admin's name
        $relevePlan = RelevePlan::create([
            'releveur' => $request->releveur,
            'periode' => $periode->id,
            'acteur' => Auth::user()->fullName,
            'version' => 0,
            'date_releve' => $request->date_releve,
            'num_tournee_debut' => $request->num_tournee_debut,
            'num_tournee_fin' => $request->num_tournee_fin,
            'ordre_lecture' => $request->ordre_lecture,
            'nombre_total' => $totalNumber,
            'temps_execution_jours' => $request->temps_execution_jours,
        ]);

        $historique = new Historique;
        $historique->releve_plan_id = $relevePlan->id;
        $historique->acteur = Auth::user()->fullName;
        $historique->acteur_type = Auth::user()->role->roleName;
        $historique->action_type = 'create';
        $historique->updated_fields = 'toutes les colonnes';
        $historique->save();

        return $relevePlan;
    }


    public function editPlan(Request $request)
    {
        // validate request 
        // if this doesnt wrok it returns a json DATE_ADD
        // dd($request->all());

        $plan = RelevePlan::findOrFail($request->id);

        // check if any values have been updated
        if (
            $plan->releveur == $request->releveur &&
            $plan->date_releve == $request->date_releve &&
            $plan->num_tournee_debut == $request->num_tournee_debut &&
            $plan->num_tournee_fin == $request->num_tournee_fin &&
            $plan->ordre_lecture == $request->ordre_lecture &&
            $plan->temps_execution_jours == $request->temps_execution_jours
        ) {
            // no changes were made
            return response()->json(['message' => 'Pas de changement effectué'], 203);
        }





        $orderLecture = $request->ordre_lecture;
        $orders = explode(' ', $orderLecture);
        $totalNumber = count($orders) * 112;



        $periode = Periode::findOrFail(1);
        $messages = [
            'releveur.required' => 'Le releveur est requis.',
            'date_releve.required' => 'La date de relève est requise.',
            'date_releve.date' => 'La date de relève doit être une date valide.',
            'date_releve.after' => 'La date de relève doit être postérieure à la date actuelle.',
            'num_tournee_debut.required' => 'Le numéro de tournée de début est requis.',
            'num_tournee_debut.regex' => 'Le numéro de tournée de début doit être de la forme XXX XXX XXX désignant Zone Maison Etage.',
            'num_tournee_fin.required' => 'Le numéro de tournée de fin est requis.',
            'num_tournee_fin.regex' => 'Le numéro de tournée de fin doit être de la forme XXX XXX XXX désignant Zone Maison Etage.',
            'ordre_lecture.required' => 'L\'ordre de lecture est requis.',
            'ordre_lecture.regex' => 'L\'ordre de lecture doit être de la forme "nombre1 nombre2 ...".',
            'temps_execution_jours.required' => 'Le temps d\'exécution en jours est requis.',
            'temps_execution_jours.integer' => 'Le temps d\'exécution en jours doit être un nombre entier.',
            'temps_execution_jours.min' => 'Le temps d\'exécution en jours doit être au moins égal au nombre de paquets.',
            'temps_execution_jours.max' => 'Le temps d\'exécution en jours ne doit pas dépasser 1,5 fois le nombre de paquets.',
        ];

        $this->validate($request, [
            'id' => 'required',
            'releveur' => [
                'required',
                // function ($attribute, $value, $fail) use ($request) {
                //     // l'id du nouveau releveur
                //     // $newReleveurId = Releveur::whereSerialNumber($request->releveur)->id;
        
                //     // l'id du planning qu'on est en cours de l'éditer
                //     $planning = RelevePlan::find($request->id);

                //     // calcul de la date fin de ce planning 
                //     $dateFinPrev = Carbon::parse($planning->date_releve)->addDays($planning->temps_execution_jours - 1);

                //     $autresPlannings = RelevePlan::where('releveur', $request->releveur)
                //         ->where('id', '<>', $planning->id)
                //         ->get();

                //     // Vérifier s'il y a un conflit de planning avec les autres plannings attribués au nouveau releveur
                //     foreach ($autresPlannings as $autrePlanning) {

                //         // la date fin de l'autre planning selon la boucle
                //         $autreDateFinPrev = Carbon::parse($autrePlanning->date_releve)->addDays($autrePlanning->temps_execution_jours - 1);

                //         if (
                //             ($planning->date_releve >= $autrePlanning->date_releve && $planning->date_releve <= $autreDateFinPrev) ||
                //             ($dateFinPrev >= $autrePlanning->date_releve && $dateFinPrev <= $autreDateFinPrev)
                //         ) {
                //             $fail('Le releveur est déjà assigné à un autre planning sur cette période.');
                //             return;
                //         }
                //     }
                // }
            ],
            // 'date_releve' => ['required', 'date', 'after:' . Carbon::now()->addDays(5)->toDateString()],
            'date_releve' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $dateReleve = Carbon::parse($value);
                    $dateFin = $dateReleve->copy()->addDays($request->temps_execution_jours - 1);
                    $currentDate = Carbon::now();

                    // Retrieve the planning based on the given releveur
                    $planning = RelevePlan::where('id', $request->id)->first();

                    $date_fin = Carbon::parse($planning->date_releve)->copy()->addDays($request->temps_execution_jours - 1);
                    // Check if the planning has a current date range
                    if ($planning && $planning->date_releve <= $currentDate && $date_fin >= $currentDate) {
                        // The planning is currently in progress, skip the validation
                        return;
                    }

                    if ($dateReleve->startOfDay()->isBefore($currentDate->startOfDay())) {
                        $fail('La date de relève doit être une date ultérieure à aujourd\'hui.');
                    }
                },

                function ($attribute, $value, $fail) use ($request) {
                    $dateFin = Carbon::parse($request->date_releve)->addDays($request->temps_execution_jours - 1);
                    $dateFinDuMois = Carbon::parse($request->date_releve)->endOfMonth();
                    if ($dateFin > $dateFinDuMois) {
                        $fail("la fin de la relève doit être dans le mois courant de " . Carbon::now()->format('F'));
                    }
                    if (Carbon::parse($value)->startOfMonth()->ne(Carbon::now()->startOfMonth())) {
                        $fail("la relève doit commencer dans le mois courant de " . Carbon::now()->format('m'));

                    }
                },
                function ($attribute, $value, $fail) use ($request) {
                    $dateReleve = Carbon::parse($value);
                    $dateFin = $dateReleve->copy()->addDays($request->temps_execution_jours - 1);
                    $currentDate = Carbon::now();

                    if (!($dateFin->isAfter($currentDate))) {
                        $fail('La date de relève doit être une date future, ce plan de relève supposé être déja terminé');
                    }
                },
            ],
            
            'num_tournee_debut' => [
                'required',
                'regex:/^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $suffixe_debut = substr($request->input('num_tournee_debut'), 8);

                    if ($suffixe_debut > 30) {
                        $fail("Le nombre des étages pour un seul foyer ne doit pas dépasser 30.");
                    }
                },
            ],


            'num_tournee_fin' => [
                'required',
                'regex:/^[0-9]{3}\s[0-9]{3}\s[0-9]{3}$/',
                function ($attribute, $value, $fail) use ($request) {
                    // validation de la valeur de num_tournee_fin
                    $prefix_debut = substr($request->input('num_tournee_debut'), 0, 3);
                    $prefix_fin = substr($request->input('num_tournee_fin'), 0, 3);
                    $suffixe_fin_h = substr($request->input('num_tournee_fin'), 8);

                    if ($suffixe_fin_h > 30) {
                        $fail("Le nombre des étages pour un seul foyer ne doit pas dépasser 30.");
                    }
                    if ($prefix_debut !== $prefix_fin) {
                        $fail("Le préfixe du numéro de tournée de fin (numéro de la zone) doit être identique à celui du numéro de tournée de début.");
                    }

                    $suffixe_debut = substr($request->input('num_tournee_debut'), 4);
                    $suffixe_fin = substr($request->input('num_tournee_fin'), 4);
                    if ($suffixe_debut >= $suffixe_fin) {
                        $fail("Le suffixe du numéro de tournée de fin doit être supérieur à celui du numéro de tournée de début.");
                    }

                    $difference_yyy = intval($suffixe_fin) - intval($suffixe_debut);
                    if ($difference_yyy > 500) {
                        $fail("le nombre de maisons/appartements pour un seul planning doit être au maximum de 500.");
                    }
                    if ($difference_yyy < 50) {
                        $fail("un planning doit au moins contenir 50 maisons/appartements");
                    }


                    $plannings = RelevePlan::where('id', '<>', $request->id)->get();
                    foreach ($plannings as $planning) {
                        $planning_debut = $planning->num_tournee_debut;
                        $planning_fin = $planning->num_tournee_fin;

                        if ($request->input('num_tournee_debut') >= $planning_debut && $request->input('num_tournee_fin') <= $planning_fin) {
                            // Case 1: The range of tour numbers is included in another planning
                            $fail("La plage de numéro de tournée est incluse dans un autre planning.");
                            break;
                        }

                        if ($request->input('num_tournee_debut') <= $planning_debut && $request->input('num_tournee_fin') >= $planning_fin) {
                            // Case 2: The planning contains an existing planning
                            $fail("Le planning contient un planning existant.");
                            break;
                        }

                        if ($request->input('num_tournee_debut') >= $planning_debut && $request->input('num_tournee_debut') <= $planning_fin) {
                            // Case 3: The beginning of the planning overlaps with an existing planning
                            $fail("Le début du planning chevauche un planning existant.");
                            break;
                        }

                        if ($request->input('num_tournee_fin') >= $planning_debut && $request->input('num_tournee_fin') <= $planning_fin) {
                            // Case 4: The end of the planning overlaps with an existing planning
                            $fail("La fin du planning chevauche un planning existant.");
                            break;
                        }
                    }


                },
            ],
            'ordre_lecture' => [
                'required',
                'regex:/^\d+(\s+\d+)*$/',
                function ($attribute, $value, $fail) use ($request) {
                    $numTourneeDebut = $request->num_tournee_debut;
                    $numTourneeDebutParts = explode(' ', $numTourneeDebut);
                    $numTourneePrefix = $numTourneeDebutParts[0];
                    $numTourneeFinParts = explode(' ', $request->num_tournee_fin);
                    $numTourneeFinPrefix = $numTourneeFinParts[0];
                    $numbers = explode(' ', $request->ordre_lecture);
                    $count = count($numbers);
                    if (($numTourneeDebutParts[1] == $numTourneeFinParts[1]) && $count !== 1) {
                        $fail("l'ordre de lecture doit avoir un seul paquet car on est dans la meme maison");
                    }
                    if ($count != count(array_unique($numbers))) {
                        $counted = array_count_values($numbers);
                        foreach ($counted as $number => $occurrences) {
                            if ($occurrences > 1) {
                                $fail("les paquets doivent être uniques ");
                                break;
                            }
                        }

                    }
                    if ($count > 5) {
                        $fail("Le total des paquets ne doit pas dépasser 5 paquets pour un seul planning.");
                    }
                },
                function ($attribute, $value, $fail) {
                    $numbers = array_unique(explode(' ', $value));
                    $count = count($numbers);
                    foreach ($numbers as $number) {
                        if ($number <= 0) {
                            $fail($attribute . 'ne doit pas contenir des nombres négatifs ou nuls');
                        }
                    }
                },

            ],

            'temps_execution_jours' => [
                'required',
                'integer',
                'min:' . ceil(count(explode(' ', $request->ordre_lecture))),
                'max:' . ceil(count(explode(' ', $request->ordre_lecture)) * 1.5),
                function ($attribute, $value, $fail) use ($request) {
                    $releveur = $request->releveur;
                    $plannings = RelevePlan::where('releveur', $releveur)->get();
                    $total_temps_execution_jours = 0;
                    foreach ($plannings as $planning) {
                        $total_temps_execution_jours += $planning->temps_execution_jours;
                    }
                    if ($total_temps_execution_jours + $value > 30) {
                        $fail("La somme des temps d'exécution en jours pour ce relevéur ne doit pas dépasser 30 jours.");
                    }
                },
                function ($attribute, $value, $fail) use ($request) {
                    $planId = $request->input('id');
                    $dateReleve = $request->input('date_releve');
                    $newTempsExecutionJours = (int) $value;

                    // Retrieve existing plans for the same releveur
                    $existingPlans = RelevePlan::where('releveur', $request->input('releveur'))
                        ->where('id', '!=', $planId)
                        ->get();

                    // Calculate the new end date based on the modified temps_execution_jours value
                    $newDateFin = date('Y-m-d', strtotime($dateReleve . ' +' . ($newTempsExecutionJours - 1) . ' days'));

                    // Check for overlapping dates with other plans
                    foreach ($existingPlans as $existingPlan) {
                        $existingDateReleve = $existingPlan->date_releve;
                        $existingDateFin = date('Y-m-d', strtotime($existingDateReleve . ' +' . ($existingPlan->temps_execution_jours - 1) . ' days'));

                        if (($dateReleve <= $existingDateFin && $newDateFin >= $existingDateReleve) || ($dateReleve >= $existingDateReleve && $newDateFin <= $existingDateFin) || ($dateReleve <= $existingDateReleve && $newDateFin >= $existingDateFin)) {
                            $fail('Le releveur souhaité est déjà assigné à un autre planning sur cette période.');
                            break;
                        }
                    }
                },
            ]
        ], $messages);

        $version = $request->version;
        $versionIncremented = $version + 1;

        $updatePlan = RelevePlan::whereId($request->id)->update(([
            'releveur' => $request->releveur,
            'version' => $versionIncremented,
            'date_releve' => $request->date_releve,
            'num_tournee_debut' => $request->num_tournee_debut,
            'num_tournee_fin' => $request->num_tournee_fin,
            'ordre_lecture' => $request->ordre_lecture,
            'nombre_total' => $totalNumber,
            'temps_execution_jours' => $request->temps_execution_jours,
        ]));

        if ($updatePlan) {
            // Historisation part
            $updatedFields = "";
            foreach ($request->all() as $field => $value) {
                if ($field != 'id') {
                    if ($value != $plan->$field) {
                        if ($field === 'ordre_lecture') {
                            $updatedFields .= $field . " " . 'nombre_total ';
                            continue;
                        }
                        $updatedFields .= $field . " ";
                    }
                }
            }

            $historique = new Historique;
            $historique->releve_plan_id = $request->id;
            $historique->acteur = Auth::user()->fullName;
            $historique->acteur_type = Auth::user()->role->roleName;
            $historique->action_type = 'update';
            $historique->updated_fields = $updatedFields;
            $historique->save();
            // Fin de l'historisation
        }
    }
    public function deletePlan(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $plan = RelevePlan::where('id', $request->id)->firstOrFail();

        // Historisation part
        if ($plan->delete()) {
            $historique = new Historique();
            $historique->releve_plan_id = $request->id;
            $historique->acteur = Auth::user()->fullName;
            $historique->acteur_type = Auth::user()->role->roleName;
            $historique->action_type = 'delete';
            $historique->updated_fields = 'tous les colonnes';
            $historique->save();

            // $plan->delete();

            return response()->json([
                'message' => 'Plan supprimé avec succès!'
            ]);
        }
    }


    public function getPlan(Request $request)
    {
        return RelevePlan::orderBy('id', 'desc')->paginate($request->total);
    }
    public function getHistorique(Request $request)
    {
        return Historique::orderBy('id', 'desc')->paginate($request->total);
    }

    public function upload(Request $request)
    {
        // for the image, we do the front-end and the back-end validation
        $messages = [
            'file.required' => 'Le fichier est requis.',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'Le fichier doit être au format JPEG, JPG ou PNG.',
        ];

        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,jpg ,png'
        ], $messages);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }
    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path() . '/uploads/' . $fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }
    public function getReleveurCount()
    {
        $count = Releveur::count();

        return response()->json(['count' => $count]);
    }

    public function createUser(Request $request)
    {
        $messages = [
            'fullName.required' => 'Le nom complet est requis.',
            'fullName.unique' => 'Le nom complet est déjà utilisé.',
            'fullName.regex' => 'Le nom complet doit contenir au moins trois lettres pour le prénom et le nom, séparés par un espace , de forme Nom Prénom.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être au format valide.',
            'email.unique' => 'L\'adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins six caractères.',
            'role_id.required' => 'Le rôle est requis.',
        ];

        $this->validate($request, [
            'fullName' => [
                'required',
                Rule::unique('users', 'fullName'),
                'regex:/^[a-zA-Z]{3,}\s[a-zA-Z]{3,}$/',
            ],

            'email' => 'bail|required|email|unique:users',
            // bail means if required fails it chekcs the validaation 'email
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ], $messages);

        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
            'userType' => Role::findOrFail($request->role_id)->roleName,
        ]);
        return $user;
    }
    public function editUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        // check if any values have been updated
        if (
            (
                $request->password &&
                $user->fullName == $request->fullName &&
                $user->email == $request->email &&
                $user->password == $request->password &&
                $user->role_id == $request->role_id
            ) || (
                !$request->password &&
                $user->fullName == $request->fullName &&
                $user->email == $request->email &&
                $user->role_id == $request->role_id
            )
        ) {
            // No changes were made
            return response()->json(['message' => 'Pas de changement effectué'], 203);
        }
        $messages = [
            'fullName.required' => 'Le nom complet est requis.',
            'fullName.unique' => 'Le nom complet est déjà utilisé.',
            'fullName.regex' => 'Le nom complet doit contenir au moins trois lettres pour le prénom et le nom, séparés par un espace , de forme Nom Prénom.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être au format valide.',
            'email.unique' => 'L\'adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins six caractères.',
            'role_id.required' => 'Le rôle est requis.',
        ];
        $this->validate($request, [
            'fullName' => [
                'required',
                Rule::unique('users', 'fullName')->ignore($request->id),
                'regex:/^[a-zA-Z]{3,}\s[a-zA-Z]{3,}$/',
            ],


            'email' => "bail|required|email|unique:users,email," . $request->id,
            'password' => 'min:6',
            'role_id' => 'required',
        ], $messages);
        // return 'done';
        // the email if it changes then the new email should be tunique and if it stays as i is, it is what it is
        // by "id,$request->id", we are ignoring the 'en cours d'editing' email so that the test of unique:users passes and doesn't conflicts with the 'en cours d'editing' one
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'userType' => Role::findOrFail($request->role_id)->roleName,
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        $user = User::whereId($request->id)->update($data);
        return $user;
    }

    public function getUsers(Request $request)
    {
        return User::orderBy('id', 'desc')->paginate($request->total);
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        // Supprimer le user
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function clearHistorique()
    {
        Historique::truncate();
        return response()->json(['success' => true, 'message' => 'L\'historique a été effacé avec succès.']);
    }

    public function adminLogin(Request $request)
    {
        $messages = [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être au format valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins six caractères.',
        ];

        $this->validate($request, [
            'email' => 'bail|required|email',
            // bail means if required fails it chekcs the validaation 'email
            'password' => 'bail|required|min:6',
        ], $messages);

        // this is the login process
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // if ($user->role->userType == 'User') {
            //     Auth::logout();
            //     return response()->json([
            //         'msg' => 'Informations de connexion incorrectes!'
            //     ], 401);
            // }
            return response()->json([
                'msg' => 'Vous êtes connecté(e) !',
                'user' => $user->role->roleName,
            ]);
        } else {
            return response()->json([
                'msg' => 'Les informations de connexion sont incorrectes. Veuillez réessayer.'
            ], 401);
        }
    }

    public function createRole(Request $request)
    {
        //  validation
        $messages = [
            'roleName.required' => 'Le nom du rôle est requis.',
            'roleName.unique' => 'Ce nom de rôle existe déjà.',
            'description.required' => 'La description du rôle est requise.',
        ];

        $this->validate($request, [
            'roleName' => 'required|unique:roles',
            'description' => 'required',
        ], $messages);
        return Role::create([
            'roleName' => $request->roleName,
            'description' => $request->description,
        ]);
    }

    public function getRoles(Request $request)
    {
        return Role::orderBy('id', 'desc')->paginate($request->total);
    }

    public function editRole(Request $request)
    {
        $role = Role::findOrFail($request->id);

        // check if any values have been updated
        if (
            ($role->roleName == $request->roleName &&
                $role->description == $request->description)
        ) {
            // no changes were made
            return response()->json(['message' => 'Pas de changement effectué'], 203);
        }

        $messages = [
            'roleName.required' => 'Le nom du rôle est requis.',
            'roleName.unique' => 'Ce nom de rôle existe déjà.',
            'description.required' => 'La description du rôle est requise.',
        ];

        $this->validate($request, [
            'roleName' => [
                'required',
                Rule::unique('roles', 'roleName')->ignore($role->id)
            ],
            'description' => 'required',
        ], $messages);

        return Role::where('id', $request->id)->update([
            'roleName' => $request->roleName,
            'description' => $request->description,
        ]);
    }
    public function deleteRole(Request $request)
    {
        $role = Role::findOrFail($request->id);

        $role->users()->delete();

        $role->delete();

        return response()->json(['success' => true]);
    }

    public function assignRole(Request $request)
    {
        // validation is to prevent someone to mess around with your database
        $messages = [
            'id.required' => 'Le champ ID est requis.',
            'permission.required' => 'Le champ Permission est requis.',
        ];
        $this->validate($request, [
            'id' => 'required',
            'permission' => 'required',
        ], $messages);
        return Role::whereId($request->id)->update([
            'permission' => $request->permission,
        ]);
    }
}
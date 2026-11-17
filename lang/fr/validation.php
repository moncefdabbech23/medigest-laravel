<?php

return [

    /*
    | Messages de validation en français.
    | :attribute est remplacé par le nom du champ (voir 'attributes' en bas).
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'after' => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date égale ou postérieure au :date.',
    'array' => 'Le champ :attribute doit être une liste.',
    'before' => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date égale ou antérieure au :date.',
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe actuel est incorrect.',
    'date' => 'Le champ :attribute n’est pas une date valide.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'different' => 'Les champs :attribute et :other doivent être différents.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'exists' => 'La valeur choisie pour :attribute n’existe pas.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'image' => 'Le champ :attribute doit être une image (jpg, png, webp…).',
    'in' => 'La valeur choisie pour :attribute est invalide.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'max' => [
        'array' => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
        'file' => 'Le fichier :attribute ne doit pas dépasser :max Ko.',
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ],
    'mimes' => 'Le fichier :attribute doit être de type : :values.',
    'min' => [
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
        'file' => 'Le fichier :attribute doit faire au moins :min Ko.',
        'numeric' => 'Le champ :attribute doit être au moins :min.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'Le champ :attribute est obligatoire quand :other vaut :value.',
    'same' => 'Les champs :attribute et :other doivent être identiques.',
    'size' => [
        'array' => 'Le champ :attribute doit contenir :size éléments.',
        'file' => 'Le fichier :attribute doit faire :size Ko.',
        'numeric' => 'Le champ :attribute doit valoir :size.',
        'string' => 'Le champ :attribute doit contenir :size caractères.',
    ],
    'string' => 'Le champ :attribute doit être un texte.',
    'unique' => 'Ce :attribute est déjà utilisé.',
    'uploaded' => 'Le fichier :attribute n’a pas pu être envoyé (trop lourd ?).',

    /*
    | Messages personnalisés pour un champ précis : 'champ' => ['règle' => 'message']
    */
    'custom' => [
        'email' => [
            'unique' => 'Cette adresse email est déjà utilisée par un autre compte.',
        ],
        'time' => [
            'required' => 'Choisissez une heure de rendez-vous.',
        ],
        'date' => [
            'after_or_equal' => 'La date du rendez-vous ne peut pas être dans le passé.',
        ],
    ],

    /*
    | Noms des champs en français (remplacent :attribute)
    */
    'attributes' => [
        'name' => 'nom',
        'email' => 'adresse email',
        'password' => 'mot de passe',
        'current_password' => 'mot de passe actuel',
        'phone' => 'téléphone',
        'address' => 'adresse',
        'birth_date' => 'date de naissance',
        'gender' => 'sexe',
        'blood_type' => 'groupe sanguin',
        'allergies' => 'allergies',
        'chronic_diseases' => 'maladies chroniques',
        'emergency_contact' => 'contact d’urgence',
        'avatar' => 'photo de profil',

        'specialty_id' => 'spécialité',
        'city_id' => 'ville',
        'office_address' => 'adresse du cabinet',
        'fee' => 'tarif',
        'description' => 'présentation',
        'icon' => 'icône',
        'form' => 'forme',

        'date' => 'date',
        'time' => 'heure',
        'reason' => 'motif',
        'status' => 'statut',
        'diagnosis' => 'diagnostic',
        'notes' => 'notes',
        'result' => 'résultat',
        'result_file' => 'fichier PDF',
        'report' => 'compte rendu',
        'image' => 'image',

        'items.*.medication_id' => 'médicament',
        'items.*.dosage' => 'dosage',
        'items.*.frequency' => 'fréquence',
        'items.*.duration' => 'durée',
        'availabilities.*.start_time' => 'heure de début',
        'availabilities.*.end_time' => 'heure de fin',
        'availabilities.*.slot_duration' => 'durée du créneau',
    ],

];
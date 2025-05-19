flowchart TD
    Accueil["Accueil"] --> Recherche["Rechercher film/série"] & Movies["Films"] & Series["Séries"]
    Recherche --> Resultats["Résultats de recherche"]
    Movies --> Detail["Détail film/série"]
    Series --> Detail
    Resultats --> Detail

    Connexion["Connexion"] --> FonctionsAuth["Fonctionnalités authentifiées"]
    Inscription["Inscription"] --> Connexion
    MDP["Mot de passe oublié"] --> Connexion
    
    FonctionsAuth --> Profil["Profil"] & Avis["Laisser un avis"] & Admin["Tableau de bord admin"]
    Profil --> ModifInfos["Modifier infos"] & ModifMDP["Modifier mot de passe"] & SuppCompte["Supprimer compte"]
    Admin --> GUser["Gérer utilisateurs"] & GAvis["Gérer avis"]
    GAvis --> ModAvis["Modération avis"]

    Detail --> Avis
    
    Connexion:::mvp
    Accueil:::mvp
    Admin:::mvp
    Inscription:::mvp
    MDP:::mvp
    Recherche:::mvp
    Profil:::mvp
    Movies:::mvp
    Series:::mvp
    Resultats:::mvp
    Detail:::mvp
    Avis:::mvp
    ModifInfos:::mvp
    ModifMDP:::mvp
    SuppCompte:::mvp
    GUser:::mvp
    GAvis:::mvp
    ModAvis:::mvp
    FonctionsAuth:::mvp
    classDef mvp fill:#d2f3e6,stroke:#2b7a78,stroke-width:2px
    classDef future fill:#ffe5c2,stroke:#e67e22,stroke-width:2px 



<div align="center">

# Gestion des Relevés de Compteurs Eau & Électricité

Application SPA de planification et de suivi des relevés de compteurs, développée durant un stage de 2 mois chez **RADEM**.

![License](https://img.shields.io/badge/license-MIT-green)
![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?logo=vuedotjs&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)

</div>

## Sommaire

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Acteurs du système](#acteurs-du-système)
- [Conception / Modélisation](#conception--modélisation)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Licence](#licence)

## Aperçu

Ce projet a pour but de digitaliser et d'optimiser la planification des relevés de compteurs d'eau et d'électricité. Développée avec **Vue.js** en frontend et **Laravel** en backend, l'application propose une interface interactive et responsive, appuyée par une modélisation des données et des processus suivant la méthode **Merise**.

Les administrateurs peuvent consulter les relevés du mois en cours, gérer les plannings des releveurs, et l'accès aux différentes fonctionnalités est contrôlé par un système de rôles dynamique et flexible. L'application a été pensée pour répondre précisément aux besoins opérationnels de RADEM.

## Fonctionnalités

- Planification et suivi des tournées de relevé
- Tableau de bord admin avec vue mensuelle des relevés
- Système de rôles et permissions dynamique (Super Admin, Admin, Releveur, Utilisateur)
- Historique des relevés par compteur
- Interface SPA réactive (Vue Router + Vuex)
- Authentification API via Laravel Sanctum

## Stack technique

| Côté | Technologies |
| --- | --- |
| **Frontend** | Vue 3, Vue Router, Vuex, Bootstrap 5, Tailwind CSS |
| **Backend** | Laravel 10, PHP 8.1, Laravel Sanctum |
| **Base de données** | MySQL |

## Acteurs du système

![Acteurs du système](Readme_images/1.png)

## Conception / Modélisation

### Diagrammes de cas d'utilisation

#### Système global

![Diagramme de cas d'utilisation général](Readme_images/2.png)

#### Super Admin

![Diagramme de cas d'utilisation Super Admin](Readme_images/5.png)

#### Admin

![Diagramme de cas d'utilisation Admin](Readme_images/6.png)

#### Utilisateur

![Diagramme de cas d'utilisation Utilisateur](Readme_images/7.png)

### Diagramme de séquence

![Diagramme de séquence](Readme_images/3.png)

### Diagramme de classes

![Diagramme de classes](Readme_images/4.png)

## Installation

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/Abdelkrim7Be/Water-and-Electricity-Meter-Reader-Management-System.git
   ```
2. Se placer dans le dossier du projet.
3. Installer les dépendances :

   Frontend :
   ```bash
   npm install
   ```

   Backend :
   ```bash
   composer install
   ```
4. Configurer les variables d'environnement (copier `.env.example` vers `.env` et adapter les accès base de données).
5. Générer la clé d'application :
   ```bash
   php artisan key:generate
   ```
6. Importer la base de données : dupliquer `releve.sql.example` en `releve.sql` (données factices) et l'importer dans MySQL, ou utiliser votre propre jeu de données.
7. Installer `concurrently` pour lancer frontend et backend en parallèle :
   ```bash
   npm install -g concurrently
   ```
8. Compiler les assets et démarrer les serveurs de développement :
   ```bash
   npm run dev
   ```

## Utilisation

Une fois les serveurs lancés, l'application est accessible via votre navigateur :

- Backend Laravel : `http://localhost:8000` (ou `http://127.0.0.1:8000`)
- Frontend Vue.js : `http://localhost:8080`

## Licence

Distribué sous licence [MIT](LICENSE).

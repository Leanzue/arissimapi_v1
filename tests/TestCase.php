<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use createsApplication;

    /**
     * Configure l'environnement avant chaque test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Initialiser les configurations nécessaires pour les tests

        // Réinitialise la base de données
        $this->artisan('migrate:fresh');

        // Charge les seeders
        $this->artisan('db:seed');
    }

    /**
     * Nettoie les ressources après chaque test.
     */
    protected function tearDown(): void
    {
        // Libérer les ressources si nécessaire
        parent::tearDown();
    }

    /**
     * Méthode d'authentification d'un utilisateur pour les tests.
     *
     * @param \App\Models\User $user
     * @return void
     */
    protected function signIn(\App\Models\User $user): void
    {
        $this->actingAs($user);
    }

    /**
     * Méthode utilitaire pour simplifier les requêtes JSON POST.
     *
     * @param string $endpoint
     * @param array $data
     * @return \Illuminate\Testing\TestResponse
     */
    protected function postJsonData($endpoint, array $data = [])

    {
        return $this->postJson($endpoint, $data);
    }
}

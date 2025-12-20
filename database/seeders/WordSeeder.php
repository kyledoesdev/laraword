<?php

namespace Database\Seeders;

use App\Console\Commands\SetDailyWord;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $targetWords = $this->getTargetWords();
        
        foreach ($targetWords as $word) {
            Word::updateOrCreate(
                ['word' => strtoupper($word)],
                ['is_target' => true]
            );
        }
        
        $this->command->info(count($targetWords) . ' dev words seeded!');

        Artisan::call(SetDailyWord::class);
    }

    protected function getTargetWords(): array
    {
        return [
            // Laravel specific
            'BLADE', 'MODEL', 'ROUTE', 'QUEUE', 'EVENT', 'CACHE', 'FORGE', 'VAPOR',
            'SCOUT', 'PULSE', 'SPARK', 'ENVOY', 'MIXIN',
            
            // PHP keywords & functions
            'ARRAY', 'CLASS', 'TRAIT', 'CONST', 'FINAL', 'CLONE', 'THROW', 'CATCH',
            'YIELD', 'MATCH', 'PRINT', 'ISSET', 'EMPTY', 'UNSET', 'WHILE', 'BREAK',
            'FLOAT', 'MIXED', 'FALSE', 'COUNT', 'MERGE', 'PARSE', 'CHMOD', 'MKDIR',
            
            // Database & ORM
            'QUERY', 'TABLE', 'INDEX', 'FIELD', 'VALUE', 'WHERE', 'ORDER', 'GROUP',
            'LIMIT', 'INNER', 'OUTER', 'JOINS', 'PIVOT', 'MORPH', 'SCOPE', 'PLUCK',
            'CHUNK', 'FIRST', 'FRESH', 'SAVED', 'SEEDS', 'STORE',
            
            // Web & HTTP
            'HTTPS', 'FETCH', 'PATCH', 'PROXY', 'HOSTS', 'PORTS', 'POSTS', 'HEADS',
            'PARAM', 'TOKEN', 'OAUTH', 'LOGIN', 'ADMIN', 'GUARD', 'ROLES', 'RULES',
            
            // Infrastructure
            'REDIS', 'MYSQL', 'NGINX', 'LINUX', 'SHELL', 'SERVE', 'BUILD', 'STACK',
            'SETUP', 'TESTS', 'DEBUG', 'ERROR', 'PATHS', 'FILES', 'ASSET',
            
            // Code concepts
            'ASYNC', 'AWAIT', 'BATCH', 'TRANS', 'TYPES', 'UNION', 'VALID', 'CHECK',
            'CLEAR', 'CRYPT', 'DATES', 'ENUMS', 'FAKER', 'FLASH', 'INPUT', 'MACRO',
            'MAILS', 'NAMES', 'READS', 'RESET', 'SLOTS', 'SLUGS', 'SORTS', 'STATE',
            'TASKS', 'TRIMS', 'USING', 'VIEWS', 'WIRES', 'WORKS', 'WRITE', 'LOOPS',
        ];
    }
}
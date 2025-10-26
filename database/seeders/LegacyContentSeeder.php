<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class LegacyContentSeeder extends Seeder
{
    /**
     * @var array<string>
     */
    private array $tables = [
        'articletype',
        'article',
        'unit_type',
        'commercial',
        'slideshow',
        'seo',
        'profile',
        'modul',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('db_gtr.sql');

        if (! File::exists($sqlPath)) {
            $this->command?->warn('db_gtr.sql tidak ditemukan, melewati import legacy.');

            return;
        }

        $sql = File::get($sqlPath);

        Schema::disableForeignKeyConstraints();

        foreach ($this->tables as $table) {
            DB::statement(sprintf('TRUNCATE TABLE `%s`', $table));

            foreach ($this->extractInsertStatements($sql, $table) as $statement) {
                DB::unprepared($statement);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @return array<int, string>
     */
    private function extractInsertStatements(string $sql, string $table): array
    {
        $needle = sprintf('INSERT INTO `%s`', $table);
        $length = strlen($sql);
        $offset = 0;
        $statements = [];

        while (($start = strpos($sql, $needle, $offset)) !== false) {
            $end = $this->findStatementEnd($sql, $start + strlen($needle));

            if ($end === null) {
                break;
            }

            $statements[] = substr($sql, $start, $end - $start + 1);
            $offset = $end + 1;
        }

        return $statements;
    }

    private function findStatementEnd(string $sql, int $from): ?int
    {
        $length = strlen($sql);
        $inString = false;

        for ($position = $from; $position < $length; $position++) {
            $char = $sql[$position];

            if ($char === '\'' && ! $this->isEscapedQuote($sql, $position)) {
                if ($inString && $position + 1 < $length && $sql[$position + 1] === '\'') {
                    $position++;

                    continue;
                }

                $inString = ! $inString;
            }

            if (! $inString && $char === ';') {
                return $position;
            }
        }

        return null;
    }

    private function isEscapedQuote(string $sql, int $position): bool
    {
        $backslashes = 0;

        while ($position > 0 && $sql[$position - 1] === '\\') {
            $backslashes++;
            $position--;
        }

        return $backslashes % 2 === 1;
    }
}

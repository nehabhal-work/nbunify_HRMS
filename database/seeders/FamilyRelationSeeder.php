<?php

namespace Database\Seeders;

use App\Models\FamilyRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relations = [
            ['FATHER', 'SON', 'male'],
            ['FATHER', 'DAUGHTER', 'female'],
            ['FATHER', 'OTHER', 'other'],
            ['MOTHER', 'SON', 'male'],
            ['MOTHER', 'DAUGHTER', 'female'],
            ['MOTHER', 'OTHER', 'other'],
            ['HUSBAND', 'WIFE', 'female'],
            ['HUSBAND', 'OTHER', 'other'],
            ['WIFE', 'HUSBAND', 'male'],
            ['WIFE', 'OTHER', 'other'],
            ['BROTHER', 'BROTHER', 'male'],
            ['BROTHER', 'SISTER', 'female'],
            ['BROTHER', 'OTHER', 'other'],
            ['SISTER', 'BROTHER', 'male'],
            ['SISTER', 'OTHER', 'other'],
            ['SON', 'FATHER', 'male'],
            ['SON', 'MOTHER', 'female'],
            ['SON', 'OTHER', 'other'],
            ['DAUGHTER', 'FATHER', 'male'],
            ['DAUGHTER', 'MOTHER', 'female'],
            ['DAUGHTER', 'OTHER', 'other'],
            ['FATHER-IN-LAW', 'SON-IN-LAW', 'male'],
            ['FATHER-IN-LAW', 'DAUGHTER-IN-LAW', 'female'],
            ['FATHER-IN-LAW', 'OTHER', 'other'],
            ['MOTHER-IN-LAW', 'SON-IN-LAW', 'male'],
            ['MOTHER-IN-LAW', 'DAUGHTER-IN-LAW', 'female'],
            ['MOTHER-IN-LAW', 'OTHER', 'other'],
            ['SON-IN-LAW', 'FATHER-IN-LAW', 'male'],
            ['SON-IN-LAW', 'MOTHER-IN-LAW', 'female'],
            ['SON-IN-LAW', 'OTHER', 'other'],
            ['DAUGHTER-IN-LAW', 'FATHER-IN-LAW', 'male'],
            ['DAUGHTER-IN-LAW', 'MOTHER-IN-LAW', 'female'],
            ['DAUGHTER-IN-LAW', 'OTHER', 'other'],
            ['GRAND-DAUGHTER', 'GRAND-FATHER', 'male'],
            ['GRAND-DAUGHTER', 'GRAND-MOTHER', 'female'],
            ['GRAND-DAUGHTER', 'OTHER', 'other'],
            ['GRAND-SON', 'GRAND-FATHER', 'male'],
            ['GRAND-SON', 'GRAND-MOTHER', 'female'],
            ['GRAND-SON', 'OTHER', 'other'],
            ['BROTHER-IN-LAW', 'BROTHER-IN-LAW', 'male'],
            ['BROTHER-IN-LAW', 'SISTER-IN-LAW', 'female'],
            ['BROTHER-IN-LAW', 'OTHER', 'other'],
            ['SISTER-IN-LAW', 'BROTHER-IN-LAW', 'male'],
            ['SISTER-IN-LAW', 'SISTER-IN-LAW', 'female'],
            ['SISTER-IN-LAW', 'OTHER', 'other'],
            ['FRIEND', 'FRIEND', 'other'],
            ['OTHER', 'OTHER', 'other'],
            ['UNCLE', 'NEPHEW', 'male'],
            ['UNCLE', 'NEICE', 'female'],
            ['UNCLE', 'OTHER', 'other'],
            ['AUNT', 'NEPHEW', 'male'],
            ['AUNT', 'NEICE', 'female'],
            ['AUNT', 'OTHER', 'other'],
            ['NEPHEW', 'UNCLE', 'male'],
            ['NEPHEW', 'AUNT', 'female'],
            ['NEPHEW', 'OTHER', 'other'],
            ['NEICE', 'UNCLE', 'male'],
            ['NEICE', 'AUNT', 'female'],
            ['NEICE', 'OTHER', 'other'],
            ['GRAND-FATHER', 'GRAND-SON', 'male'],
            ['GRAND-FATHER', 'GRAND-DAUGHTER', 'female'],
            ['GRAND-FATHER', 'OTHER', 'other'],
            ['GRAND-MOTHER', 'GRAND-SON', 'male'],
            ['GRAND-MOTHER', 'GRAND-DAUGHTER', 'female'],
            ['GRAND-MOTHER', 'OTHER', 'other'],
            ['COUSIN', 'COUSIN', 'male'],
            ['COUSIN', 'COUSIN', 'female'],
            ['COUSIN', 'COUSIN', 'other'],
            ['BROTHER','BROTHER','male'],
            ['SISTER','SISTER','female'],
        ];

        foreach ($relations as $relation) {
            FamilyRelation::updateOrCreate([
                'main_relation' => $relation[0],
                'relative_relation' => $relation[1],
                'gender' => $relation[2],
            ], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

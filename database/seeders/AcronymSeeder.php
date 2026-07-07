<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Acronym;

class AcronymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $acronyms = [
            // Government & Organizations
            ['acronym' => 'PPP', 'standfor' => 'Public Private Partnership'],
            ['acronym' => 'KP', 'standfor' => 'Khyber Pakhtunkhwa'],
            ['acronym' => 'KPK', 'standfor' => 'Khyber Pakhtunkhwa'],
            ['acronym' => 'FWO', 'standfor' => 'Frontier Works Organization'],
            ['acronym' => 'ZKB', 'standfor' => 'Zarai Taraqiati Bank'],
            ['acronym' => 'AIIB', 'standfor' => 'Asian Infrastructure Investment Bank'],
            ['acronym' => 'IFC', 'standfor' => 'International Finance Corporation'],
            ['acronym' => 'FCDO', 'standfor' => 'Foreign, Commonwealth & Development Office'],
            ['acronym' => 'ADB', 'standfor' => 'Asian Development Bank'],
            ['acronym' => 'P&D', 'standfor' => 'Planning & Development Department'],
            ['acronym' => 'NHA', 'standfor' => 'National Highway Authority'],
            ['acronym' => 'CDA', 'standfor' => 'Capital Development Authority'],
            
            // Consulting & Professional Services
            ['acronym' => 'PwC', 'standfor' => 'PricewaterhouseCoopers'],
            ['acronym' => 'RSM', 'standfor' => 'RSM Global'],
            ['acronym' => 'KPMG', 'standfor' => 'Klynveld Peat Marwick Goerdeler'],
            ['acronym' => 'EY', 'standfor' => 'Ernst & Young'],
            ['acronym' => 'Nespak', 'standfor' => 'National Engineering Services Pakistan'],
            ['acronym' => 'NESPAK', 'standfor' => 'National Engineering Services Pakistan'],
            ['acronym' => 'Pavron', 'standfor' => 'Pavron Consulting'],
            
            // Legal & Financial
            ['acronym' => 'RBG', 'standfor' => 'Riaa Barker Gillette'],
            
            // Development & Projects
            ['acronym' => 'PSDP', 'standfor' => 'Public Sector Development Programme'],
            ['acronym' => 'ADP', 'standfor' => 'Annual Development Programme'],
            ['acronym' => 'SDP', 'standfor' => 'Sector Development Programme'],
            
            // Infrastructure & Construction
            ['acronym' => 'BOT', 'standfor' => 'Build Operate Transfer'],
            ['acronym' => 'BOOT', 'standfor' => 'Build Own Operate Transfer'],
            ['acronym' => 'BOO', 'standfor' => 'Build Own Operate'],
            ['acronym' => 'DBO', 'standfor' => 'Design Build Operate'],
            ['acronym' => 'EPC', 'standfor' => 'Engineering Procurement Construction'],
            ['acronym' => 'O&M', 'standfor' => 'Operations & Maintenance'],
            
            // Energy & Power
            ['acronym' => 'KEL', 'standfor' => 'K-Electric Limited'],
            ['acronym' => 'LPG', 'standfor' => 'Liquefied Petroleum Gas'],
            ['acronym' => 'CNG', 'standfor' => 'Compressed Natural Gas'],
            
            // Information Technology
            ['acronym' => 'IT', 'standfor' => 'Information Technology'],
            ['acronym' => 'ICT', 'standfor' => 'Information & Communication Technology'],
            ['acronym' => 'ERP', 'standfor' => 'Enterprise Resource Planning'],
            
            // Other Common Acronyms
            ['acronym' => 'PPRA', 'standfor' => 'Public Procurement Regulatory Authority'],
            ['acronym' => 'SECP', 'standfor' => 'Securities and Exchange Commission of Pakistan'],
            ['acronym' => 'FBR', 'standfor' => 'Federal Board of Revenue'],
            ['acronym' => 'SBP', 'standfor' => 'State Bank of Pakistan'],
            ['acronym' => 'PIA', 'standfor' => 'Pakistan International Airlines'],
            ['acronym' => 'PTA', 'standfor' => 'Pakistan Telecommunication Authority'],
            ['acronym' => 'PEMRA', 'standfor' => 'Pakistan Electronic Media Regulatory Authority'],
            ['acronym' => 'NADRA', 'standfor' => 'National Database and Registration Authority'],
            ['acronym' => 'NTC', 'standfor' => 'National Telecommunication Corporation'],
            ['acronym' => 'PSEB', 'standfor' => 'Pakistan Software Export Board'],
            ['acronym' => 'PSQCA', 'standfor' => 'Pakistan Standards and Quality Control Authority'],
            ['acronym' => 'EPZA', 'standfor' => 'Export Processing Zones Authority'],
            ['acronym' => 'CDGK', 'standfor' => 'City District Government Karachi'],
            ['acronym' => 'KDA', 'standfor' => 'Karachi Development Authority'],
            ['acronym' => 'LDA', 'standfor' => 'Lahore Development Authority'],
            ['acronym' => 'DHA', 'standfor' => 'Defence Housing Authority'],
        ];

        // Insert all acronyms
        foreach ($acronyms as $acronym) {
            // Check if acronym already exists to avoid duplicates
            if (!Acronym::where('acronym', $acronym['acronym'])->exists()) {
                Acronym::create($acronym);
            }
        }
        
        $this->command->info('Acronyms seeded successfully!');
        $this->command->info('Total acronyms: ' . count($acronyms));
    }
}
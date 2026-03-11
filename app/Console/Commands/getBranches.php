<?php

namespace App\Console\Commands;

use App\Models\Branch\Branch;
use App\Models\Branch\BranchTranslation;
use App\Service\Foodics\FoodicsService;
use Illuminate\Console\Command;

class getBranches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-branches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Getting branches from Foodics');

        $foodicsService = new FoodicsService();

        $responseData = $foodicsService->getBranches();

        $data = $responseData['data'] ?? [];


        foreach($data as $branch){

            $existingBranch = Branch::where('remote_id', $branch['id'])->first();

            if($existingBranch){
                continue;
            }

            $createdBranch = Branch::create([
                'remote_id' => $branch['id'],
                'reference' => $branch['reference'],
                'type'      => $branch['type'],
                'lat'       => $branch['latitude'] ?? '',
                'lng'       => $branch['longitude'] ?? '',
                'phone'     => $branch['phone'] ,
                'address'   => $branch['address'] ?? '',
            ]);

            BranchTranslation::create([
                'branch_id' => $createdBranch->id,
                'title' => $branch['name'],
                'locale' => 'ar',
            ]);

            BranchTranslation::create([
                'branch_id' => $createdBranch->id,
                'title' =>  $branch['name'],
                'locale' => 'en',
            ]);

        }

        $this->info('Branches created successfully');

        return Command::SUCCESS;
    }
}

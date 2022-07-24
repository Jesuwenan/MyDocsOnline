<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Exports\PeopleExport;
use App\Models\People\Person;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class RemoveDuplicateParticipant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:duplicate:participant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate participant';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $part = DB::table('people')->select('*')->distinct('email')->pluck('id')->toArray();
        // dd($part);
        // Person::whereIn('id', $part)->delete();
        //dd(Person::where('email','')->get()->toArray());
        //$persons = [];
        foreach (Person::get() as $person) {
            
            if(count(Person::where('email',$person->email)->get()->toArray())>1){
                Person::where('email',$person->email)->update([
                    'email' => null
                ]);
                // $person->email = null;
                // $person->save();
            }

            if(count(Person::where('phone',$person->phone)->get()->toArray())>1){
                Person::where('phone',$person->phone)->update([
                    'phone' => null
                ]);
                // $person->phone = null;
                // $person->save();
            }
        }
        // Excel::store(new PeopleExport, 'people_with_issue_list.xls','s3',null);
        // dd(Storage::temporaryUrl('people_with_issue_list.xls',Carbon::now()->addMinutes(10)));
        // dd($persons);
    }
}

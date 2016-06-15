<?php

namespace App\Console\Commands;

use App\InstagramProfile;
use Illuminate\Console\Command;
use App\Http\Controllers\InstagramController as Instagram;

class UpdateImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:update {profile_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update images of an instagram profile id';

    /**
     * Instagram image saver
     * 
     * @var App\Helpers\Instagram
     */
    protected $instagram;

    /**
     * comments to print to the user about end result of updating command
     * 
     * @var  array
     */
    private $comments;

    /**
     * End result table headers
     * 
     * @var  array
     */
    private $headers;
    private $time_start;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Instagram $instagram)
    {
        parent::__construct();

        $this->time_start = microtime(true); 
        $this->headers   = ['Profile ID', 'Image inserted', 'Profile Name'];
        $this->comments  = [];
        $this->instagram = $instagram;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * If profile_id switch did not enter, get all instagram profiles and execute
         * update on all of them, otherwise if got profile_id so just execute update
         * for that particular instagram profile id and not touch other ones images.
         */
        if ($this->argument('profile_id') == '') {
            $instagramProfiles = InstagramProfile::all();
            foreach ($instagramProfiles as $instagram) {
               $this->update($instagram->name);
            }
        } else {
            $this->update($this->argument('profile_id'));
        }
        $time_end = microtime(true);
        $execution_time = ($time_end - $this->time_start)/60;

        // Print the result in table format
        $this->table($this->headers, $this->comments);
        $this->comment('Execution Time: ' . $execution_time . ' Mins');
    }

    /**
     * Update an instagram profile images, Generate user recent media url
     * and update that user images, then print message comments on the
     * console so we see inserted images count, that's cool right?
     * 
     * @param  integer  $profile_id
     * @return string
     */
    private function update($profile_id)
    {
        $userRecentMediaURL = $this->instagram->userRecentMediaURL($profile_id);
        $this->comments[]   = $this->instagram->update( $userRecentMediaURL, $profile_id );
    }
}
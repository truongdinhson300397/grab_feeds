<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Console\Command;
use SimpleXMLElement;

class CronRssFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto update rss feeds';

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
     * @return mixed
     */
    public function handle()
    {
        $categories = $this->getDataCategories();
        $items = $this->getDataItems();
        foreach ($categories as $category) {
            $category->items()->saveMany($items);
        }
//        var_dump($this->getChunkData());
    }

    // get html rss
    protected function getHtmlRss()
    {
        return file_get_html('https://tuoitre.vn/');
    }

    // get link html rss
    protected function getLinkRss()
    {
        $links = [];
        foreach ($this->getHtmlRss()->find('link') as $element) {
            if ($element->type == "application/rss+xml") {
                $links[] = $element->href;
            }
        }
        return $links;
    }

    // get content rss
    protected function getContentRss()
    {
        $contents = [];
        foreach ($this->getLinkRss() as $link) {
            $contents[] = new SimpleXmlElement(file_get_contents($link));
        }
        return $contents;
    }

    // convert string to array of categories
    protected function getArrayCategories()
    {
        $arrays = [];
        $array_unique = [];
        foreach ($this->getContentRss() as $xml) {
            foreach ($xml->channel->category as $value) {
                array_push($arrays, explode("/", $value));
                $array_merge = array_merge(...$arrays);
                $array_unique = array_unique($array_merge);
            }
        }
        return $array_unique;
    }

    // get data categories
    protected function getDataCategories()
    {
        $listOfCategory = [];
        if (count($this->getArrayCategories()) === 0) {
            echo "No category \n";
        } else {
            foreach ($this->getArrayCategories() as $name) {
                $categories = new Category();
                $categories->name = $name;
                $categories->save();
                $listOfCategory[] = $categories;
            }
        }
        return $listOfCategory;
    }

    // chunk data
    protected function getChunkData()
    {
        $collect = [];
        foreach ($this->getContentRss() as $xml) {
            foreach ($xml->channel->item as $item) {
                $collect[] = $item;
                $chunks = collect($collect)->chunk(20);
            }
        }
        return $chunks->toArray();
    }

    // get data items
    protected function getDataItems()
    {
        $listOfItem = [];
        foreach ($this->getChunkData() as $value) {
            foreach ($value as $item) {
                $instance = new Item();
                $instance->title = $item->title;
                $instance->description = $item->description;
                $instance->author = $item->guid;
                $instance->save();
                $listOfItem[] = $instance;
                echo $instance->id;
            }
        }
        return $listOfItem;
    }

    public function updateFacebook()
    {

        //Access token
        $access_token = 'secret';
        //Request the public posts.
        $json_str = file_get_contents('https://graph.facebook.com/v3.0/NewableGroup/feed?access_token=' . $access_token);
        //Decode json string into array
        $facebookData = json_decode($json_str);

        //For each facebook post
        foreach ($facebookData->data as $data) {

            //Convert provided date to appropriate date format
            $fbDate = date("Y-m-d H:i:s", strtotime($data->created_time));
            $fbDateToStr = strtotime($fbDate);

            //If a post contains any text
            if (isset($data->message)) {

                //Create new facebook post if it does not already exist in the DB
                $facebookPost = FacebookPost::firstOrCreate(
                    ['post_id' => $data->id], ['created_at' => $fbDateToStr, 'content' => $data->message, 'featuredImage' => null]
                );

                //Output any new facebook posts to the console.
                if ($facebookPost->wasRecentlyCreated) {
                    $this->info("New Facebook Post Added --- " . $facebookPost->content);
                }

            }

        }

    }

    public function updateTwitter($amount)
    {

        $twitterData = Twitter::getUserTimeline(['count' => $amount, 'tweet_mode' => 'extended', 'format' => 'array']);

        foreach ($twitterData as $data) {

            //Convert provided date to appropriate date format
            $tweetDate = date("Y-m-d H:i:s", strtotime($data['created_at']));
            $tweetDateToStr = strtotime($tweetDate);
            $tweetImg = null;

            //Get the twitter image if any
            if (!empty($data['extended_entities']['media'])) {
                foreach ($data['extended_entities']['media'] as $v) {
                    $tweetImg = $v['media_url'];
                }
            }

            //Create new tweet if it does not already exist in the DB
            $twitterPost = TwitterPost::firstOrCreate(
                ['post_id' => $data['id']], ['created_at' => $tweetDateToStr, 'content' => $data['full_text'], 'featuredImage' => $tweetImg]
            );

            //Output any new twitter posts to the console.
            if ($twitterPost->wasRecentlyCreated) {
                $this->info("New Tweet Added --- " . $twitterPost->content);
            }

        }

    }
}

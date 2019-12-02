<?php

namespace App\Console\Commands;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Console\Command;
use SimpleXMLElement;

class GrabCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:grab {link}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        if ($this->confirm('Do you wish to continue?')) {
            $categories = $this->getDataCategories();
            $items = $this->getDataItems();
            foreach ($categories as $category) {
                $category->items()->saveMany($items);
            }
        }

//       var_dump($this->getChunkData());
    }

    // get html rss
    protected function getHtmlRss()
    {
        return file_get_html($this->argument('link'));
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
            $contents[] = file_get_contents($link);
        }
        return $contents;
    }

    // get xml rss
    protected function getXmlRss()
    {
        $xml = [];
        foreach ($this->getContentRss() as $content) {
            $xml[] = new SimpleXmlElement($content);
        }
        return $xml;
    }

    // convert string to array of categories
    protected function getArrayCategories()
    {
        $arrays = [];
        $array_unique = [];
        foreach ($this->getXmlRss() as $xml) {
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
        if($this->getArrayCategories() === null){
            echo "No category";
        }
        else{
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
        foreach ($this->getXmlRss() as $xml) {
            foreach ($xml->channel->item as $item) {
                $collect[] = $item;
                $chunk = collect($collect)->chunk(20);
            }
        }
        return $chunk->toArray();
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
                $instance->save();
                $listOfItem[] = $instance;
                echo $instance->id;
            }
        }
        return $listOfItem;
    }
}

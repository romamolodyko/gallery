<?php

/**
 * Class ImageController for work with gallery
 */
class ImageController extends Controller
{
    /** @var string Is the default action which will be use when the routing parameters won't passed */
    public $defaultAction = 'index';

    /** @var string Is the layout for render all content */
    public $layout = 'base';

    public function __construct($request)
    {
        // Call parent constructor
        parent::__construct($request);

        // Set model
        $this->model = new ImageModel();
    }

    /**
     * Is the main action to start app
     * Start write code here
     */
    public function indexAction()
    {
        // Write code here to create some functionality

        $count = 0;
        $page = 1;
        $countImage = 0;
        $count_of_page = App::get('count_of_page');
        // Get "GET" parameter count
        if ($this->request->get('page')) {
            $page = $this->request->get('page');
        }
        // IF you want use some controller in component directory you have to only use this name and don't
        // do some include of require
        // die(Helper::test());

        $pageNumber = $count_of_page * ($page-1);
        $array = $this ->model->selectAll($pageNumber, $count_of_page);
        $counter = $this ->model->count();
        $text = '';
        $textCount = '';

        // Iterate items and render views
        if ($counter > $count_of_page) {
            for ($i = 1; $i <= $counter; $i=$i+$count_of_page) {
                $count = $count + 1;
                $textCount .= $this->render('gallery.pagination', array("number_page" => $count), false, false);
            }
        }

            foreach ($array as $key) {
                $countImage = $countImage+1;
                $imageName = $key["image_name"];
                $comment = $key["comments"];
                $data = $key["date"];
                $text .= $this->render('gallery.item',
                array("imageName" => $imageName, "comment" => $comment, "data" => $data, 'countImage' => $countImage),
                false,
                false
                );
            }

        // Show main results

        $this->render('gallery.index', array('content' => $text, 'count' => $textCount));

    }

}

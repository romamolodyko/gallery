<?php

/**
 * Class ImageController for work with gallery
 */
class UploadController extends Controller
{
    /** @var string Is the default action which will be use when the routing parameters won't passed */
    public $defaultAction = 'index';

    /** @var string Is the layout for render all content */
    public $layout = 'base';
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new ImageModel();
    }
    /**
     * Is the main action to start app
     * Start write code here
     */
    public function indexAction()
    {
        // Write code here to create some functionality

        $this->render('gallery.upload');
    }

    public function saveAction()
    {
        if ($this->request->isPost() && $this->request->isFile()) {
            $file = $this->request->getParamFile("pictures");
            if ($file && $file['error'] == 0) {
                $fileName = $this->saveImageInFile($file);
                $comment = $this->request->get("comments");
                $this->saveImageInDb($fileName, $comment);

                $this->redirect();
            }
        }
    }

    public function saveImageInFile($file)
    {
        $t = $file['tmp_name'];
        $n = $file['name'];
        $path = App::get("uploads_dir_original").DIRECTORY_SEPARATOR.$n;
        move_uploaded_file($t, $path);
        $image = new SimpleImage();
        $image->load($path);
        $image->resize(250, 250);
        $image->save(App::get("uploads_dir_small").DIRECTORY_SEPARATOR.$n);
        return $n;
    }

    public function saveImageInDb($imageName, $comment)
    {
        echo $comment;
        $date = time();
        $this->model->saveDb($imageName, $date, $comment);
    }
}

<?php

namespace MediaSuite\Controller;

use MediaSuite\Utils\Tags;
use Mni\FrontYAML\Parser;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\ArrayData;

/**
 *
 */
class BlogPostsController extends Controller
{

    /**
     * @var string[]
     */
    private static $allowed_actions = [
        'showPost',
        'posts',
    ];

    /**
     * @var string[]
     */
    private static $url_handlers = [
        '$Name!' => 'showPost',
        '' => 'posts',
    ];

    /**
     * Basic Silverstipe Link
     *
     * @param null $action
     * @return string|null
     */
    public function Link($action = null)
    {
        return Controller::join_links('posts', $action);
    }

    /**
     * Show all blog posts
     *
     * @param HTTPRequest $request
     * @return DBHTMLText
     */
    public function posts(HTTPRequest $request)
    {
        $filepath = self::getBlogFilePath();
        $pages = new ArrayList();
        $files = array_slice(scandir($filepath), 2);
        if ($files && !empty($files)) {
            foreach ($files as $file) {
                $fileWithPath = $filepath.DIRECTORY_SEPARATOR.$file;
                $title = $this->getBlogTitle($fileWithPath);
                $url = $this->getBlogSlug($fileWithPath);
                $pages->push(
                    new ArrayData([
                        'Title' => $title,
                        'Slug' => $url,
                    ])
                );
            }
        }
        $arrayData = new ArrayData([
            'BlogPosts' => $pages,
        ]);

        return $this->customise([
            'Layout' => $this
                ->customise($arrayData)
                ->renderWith(['MediaSuite\Layout\BlogListings']),
        ])->renderWith(['Page']);


    }

    /**
     * Show specific blog post.
     * Note - checks for 'json' appended on url
     * Return 404 if file not found
     *
     * @param HTTPRequest $request
     * @return false|DBHTMLText|string|void
     * @throws \SilverStripe\Control\HTTPResponse_Exception
     */
    public function showPost(HTTPRequest $request)
    {
        $post = $request->param('Name');
        if ($post == 'json') {
            return $this->requestApi();
        }
        $fileName = $post.'.md';
        $filepath = self::getBlogFilePath();
        $fileWithPath = $filepath.DIRECTORY_SEPARATOR.$fileName;
        if (file_exists($fileWithPath)) {
            $title = $this->getBlogTitle($fileWithPath);
            $content = $this->getBlogContent($fileWithPath);
            $HTMLContent = DBHTMLText::create()->setValue($content);
            $rawContent = strip_tags($HTMLContent);
            $tags = Tags::getTopWords($rawContent, 5);
            $tagsArray = new ArrayList();
            foreach ($tags as $tag => $count) {
                $tagsArray->add(
                    new ArrayData([
                        'Tag' => $tag,
                        'Count' => $count,
                    ])
                );
            }
            $arrayData = new ArrayData([
                'Title' => $title,
                'Content' => $HTMLContent,
                'Tags' => $tagsArray,
            ]);

            return $this->customise([
                'Layout' => $this
                    ->customise($arrayData)
                    ->renderWith(['MediaSuite\Layout\BlogPost']),
            ])->renderWith(['Page']);
        } else {
            return $this->httpError(404);
        }

    }

    /**
     * Return JSON of blog posts
     *
     * @param HTTPRequest $request
     * @return false|string
     */
    private function requestApi()
    {
        $data = [];
        $this->response->addHeader('Content-Type', 'application/json');
        $filepath = self::getBlogFilePath();
        $files = array_slice(scandir($filepath), 2);
        if ($files && !empty($files)) {
            foreach ($files as $file) {
                $fileWithPath = $filepath.DIRECTORY_SEPARATOR.$file;
                $title = $this->getBlogTitle($fileWithPath);
                $url = $this->getBlogSlug($fileWithPath);
                $content = $this->getBlogContent($fileWithPath);
                $rawContent = strip_tags($content);
                $contentSummary = mb_strimwidth($rawContent, 0, 200, "...");
                $tags = Tags::getTopWords($rawContent, 5);
                $tagsArr = [];
                foreach ($tags as $tag => $count) {
                    array_push($tagsArr, $tag);
                }
                $data[] = array(
                    "title" => $title,
                    "slug" => $url,
                    "tags" => $tagsArr,
                    "summary" => $contentSummary,
                );

            }
        }

        return json_encode($data);
    }


    /**
     * Return files of blog entries
     *
     * @return string
     */
    private static function getBlogFilePath()
    {
        return Director::baseFolder().DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'posts';
    }

    /**
     * Extract blog title
     *
     * @param $file
     * @return string
     */
    private function getBlogTitle($file)
    {
        $lines = $this->extractHeader($file);

        return trim(str_replace("Title:", "", $lines[1]));
    }

    /**
     * Extract header helper
     * Only read the first x ammount of lines
     *
     * @param $file
     * @return array|false
     */
    private function extractHeader($file)
    {
        return array_slice(file($file), 0, 4);
    }

    /**
     * Extract the blog slug/url
     *
     * @param $file
     * @return string
     */
    private function getBlogSlug($file)
    {
        $lines = $this->extractHeader($file);

        return trim(str_replace("Slug:", '', $lines[3]));
    }

    /**
     * Extract main blog content - exclude the header
     *
     * @param $file
     * @return string
     */
    private function getBlogContent($file)
    {
        $fileToArray = file($file);
        $file = array_slice($fileToArray, 5, count($fileToArray));
        $contents = implode(" ", $file);
        $parser = new Parser;
        $document = $parser->parse($contents);

        return $document->getContent();
    }


}

<?php
/**
 * @var $app \Silex\Application
 */

use Symfony\Component\HttpFoundation\Request;

/**
 * Вывод главной страницы
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array(
        'article_id' => null,
        'is_editor' => false,
    ));
});

/**
 * Вывод статей для указанной страницы
 */
$app->get('/page/{pageId}/', function (int $pageId) use ($app) {
    /** @var \services\Recommender\RecommenderService $recommender */
    $recommender = $app['recommender'];

    $limit = 12;
    $offset = ($pageId - 1) * $limit;

    $recommender->setLimit($limit);
    $recommender->setOffset($offset);

    $documentsIdsArr = $recommender->getDocumentsIds();

    $postsEntityArr = $app['posts.repository']->findBy([
        'id' => $documentsIdsArr,
        //'status' => 'p',
    ]);

    if (empty($postsEntityArr)) {
        return json_encode([
            'count' => 0,
            'items' => [],
        ]);
    }

    $articlesArr = [];

    /** @var $postEntity \AppBundle\Entity\PostEntity */
    $ribbonsIdsArr = [];
    foreach ($postsEntityArr as $postEntity) {
        $ribbonsIdsArr[] = $postEntity->getRibbonId();
    }
    $ribbonsIdsArr = array_unique($ribbonsIdsArr);

    $ribbons = $app['ribbons.repository']->findBy([
        'id' => $ribbonsIdsArr,
    ]);
    $ribbonsReindex = [];
    /** @var $ribbon \AppBundle\Entity\Ribbon */
    foreach ($ribbons as $ribbon) {
        $ribbonsReindex[$ribbon->getId()] = $ribbon;
    }
    $ribbons = $ribbonsReindex;

    foreach ($postsEntityArr as $postEntity) {
        $ribbon = $ribbons[$postEntity->getRibbonId()];
        $articlesArr[] = $app['twig']->render('article-mini.html', [
            'atricle_id' => $postEntity->getId(),
            'atricle_title' => $postEntity->getTitle(),
            'atricle_annotation' => $postEntity->getAnnotation(),
            'atricle_image_url' => '',
            'atricle_url' => '',

            'ribbon_title' => $ribbon->getTitle(),
            'ribbon_logo_url' => $ribbon->getLogoUrl(),
        ]);
    }

    return json_encode([
        'count' => count($postsEntityArr),
        'items' => $articlesArr,
    ]);
});

/**
 * Вывод статьи по указанному идентификатору
 */
$app->get('/post/{postId}/', function (int $postId) use ($app) {

    $pageHtml = $app['twig']->render('index.html', array(
        'article_id' => $postId,
        'is_editor' => false,
    ));

    return $pageHtml;
});

/**
 * Вывод статьи по указанному идентификатору, вариант AJAX
 */
$app->get('/ajax/post/{postId}/', function (Request $request, int $postId) use ($app) {

    if (!$request->isXmlHttpRequest()) {
        return $app->redirect("/post/{$postId}/");
    }

    /**
     * @var $postEntity \AppBundle\Entity\PostEntity
     * @var $ribbonEntity \AppBundle\Entity\Ribbon
     */
    $postEntity = $app['posts.repository']->find($postId);
    $ribbonEntity = $app['ribbons.repository']->find($postEntity->getRibbonId());

    $postHtml = $app['twig']->render('article.html', array(
        'title' => $postEntity->getTitle(),
        'content' => $postEntity->getContent(),
        'source_url' => $postEntity->getSourceUrl(),
        'source_base_url' => $postEntity->getSourceBaseUrl(),
    ));

    return json_encode([
        'html' => $postHtml,
        'ribbon_title' => $ribbonEntity->getTitle(),
        'ribbon_icon' => $ribbonEntity->getLogoUrl(),
    ]);
});
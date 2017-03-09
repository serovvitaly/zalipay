<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array(
        'wrapper_widget' => 'widget/multi-column.html',
        'items_by_columns' => ['items'=>[]],
        'article_id' => null,
        'is_editor' => false,
    ));
});

/**
 * Вывод документов для указанной страницы
 */
$app->get('/page/{pageId}/', function (int $pageId) use ($app) {

    $recommender = $app['recommender'];

    $documentsIdsArr = $recommender->getDocumentsIds();

    $postsEntityArr = $app['posts.repository']->findBy([
        'id' => $documentsIdsArr,
        //'status' => 'p',
    ], null, 10, 0);

    if (empty($postsEntityArr)) {
        return '';
    }

    $outputHtml = '';

    /**
     * @var $postEntity \AppBundle\Entity\PostEntity
     */
    foreach ($postsEntityArr as $postEntity) {
        $outputHtml .= $app['twig']->render('article.html', array(
            'title' => $postEntity->getTitle(),
            'content' => $postEntity->getContent(),
        ));
    }

    return $outputHtml;
});

/**
 * Вывод документа по указанному идентификатору
 */
$app->get('/post/{postId}/', function (int $postId) use ($app) {

    $pageHtml = $app['twig']->render('index.html', array(
        'wrapper_widget' => 'widget/multi-column.html',
        'items_by_columns' => ['items'=>[]],
        'article_id' => $postId,
        'is_editor' => false,
    ));

    return $pageHtml;
});

/**
 * Вывод документа по указанному идентификатору, вариант AJAX
 */
$app->get('/ajax/post/{postId}/', function (Request $request, int $postId) use ($app) {

    if (!$request->isXmlHttpRequest()) {
        return $app->redirect("/post/{$postId}/");
    }

    /**
     * @var $postEntity \AppBundle\Entity\PostEntity
     */
    $postEntity = $app['posts.repository']->find($postId);

    $articleHtml = $app['twig']->render('article.html', array(
        'title' => $postEntity->getTitle(),
        'content' => $postEntity->getContent(),
    ));

    return $articleHtml;
});
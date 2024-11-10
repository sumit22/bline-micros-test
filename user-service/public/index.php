<?php


require __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers\UsersController;
use App\Http\Middlewares\AuthMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;

use Slim\Exception\HttpException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use App\Exceptions\ResourceNotFoundException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Routing\RouteCollectorProxy as Group;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/di-container.php');
$container = $containerBuilder->build();

$app = Bridge::create($container);

/**
 * The routing middleware should be added earlier than the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled by the middleware
 */
$app->addRoutingMiddleware();

/**
 * Add Error Middleware
 *
 * @param bool                  $displayErrorDetails -> Should be set to false in production
 * @param bool                  $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool                  $logErrorDetails -> Display error details in error log
 * @param LoggerInterface|null  $logger -> Optional PSR-3 Logger  
 *
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(false, true, true);



/**
 * Error handling starts here
 */
$errorMiddleware->setErrorHandler([
    HttpNotFoundException::class,
    ResourceNotFoundException::class,
], function (Request $request, Throwable $exception, bool $displayErrorDetails) {

    if($exception instanceof HttpNotFoundException) {}
    $response = new \Slim\Psr7\Response();
    $error = [
        'status' => 404,
        'message' => $exception?->getMessage() ?? 'The requested resource was not found.'
    ];
    $response->getBody()->write(json_encode($error));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});


$errorMiddleware->setDefaultErrorHandler(function(Request $request, Throwable $exception, bool $displayErrorDetails){
    $response = new \Slim\Psr7\Response();

    $error = match(true) {
        $exception instanceof HttpBadRequestException => [
            'status'=> 400,
            'message'=> $exception->getMessage() ?? 'Bad Request'
        ],
        $exception instanceof HttpUnauthorizedException => [
            'status'=> 401, 
            'message'=> $exception->getMessage() ?: 'Unauthorized Request'
        ],
        $exception instanceof HttpForbiddenException => [
            'status'=> 403, 
            'message'=> $exception->getMessage() ?? 'Forbidden'
        ],
        $exception instanceof DomainException => [
            'status'=> 400,
            'message'=> $exception->getMessage() ?? 'Invalid Input'
        ],
        $exception instanceof InvalidArgumentException => [
            'status'=> 422,
            'message'=> $exception->getMessage() ?? 'Invalid argument provided.'
        ],
        $exception instanceof HttpMethodNotAllowedException => [
            'status'=> 405,
            'message'=> $exception->getMessage() ?? 'Method not allowed'
        ],
        $exception instanceof HttpInternalServerErrorException => [
            'status'=> 500,
            'message'=> $exception->getMessage() ?? 'something went wrong'
        ],
        $exception instanceof HttpException => [
            'status'=> 500,
            'message'=> $exception->getMessage() ?? 'An HTTP error occurred.'
        ],

        default => [
            'status'=> 500,
            'message'=> $exception->getMessage() ?? 'something went wrong'
        ]
    };

    $response->getBody()->write(json_encode($error));
    return $response->withHeader('Content-Type', 'application/json')->withStatus($error['status']);
});

// error handling ends


/**
 * API endpoint registration
 */
$app->group('/users', function (Group $group) {
    $group->get('/', [UsersController::class, 'index']);
    $group->get('/{id}', [UsersController::class, 'getUserById']);
}); 
//->add($container->get(AuthMiddleware::class)); commenting this out as auth is now handled by kong

$app->run();
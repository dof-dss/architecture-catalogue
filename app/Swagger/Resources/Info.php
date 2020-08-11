<?php

namespace App\Swagger\Resources;

/**
 * @OA\Info(
 *      version="1.0.11",
 *      title="Architecture Catalogue",
 *      description="Architecture Catalogue API with read only access to catalogue entries",
 *      @OA\Contact(
 *          email="ea-team@ea.finance-ni.gov.uk"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 *
 * @OA\Server(
 *      url=L5_SWAGGER_SANDBOX_HOST,
 *      description="Sandbox server (uses test data)"
 * )
 *
 * @OA\Tag(
 *     name="Architecture Catalogue",
 *     description="API Endpoints of Architecture Catalogue"
 * )
 *
 *
 * @OA\SecurityScheme(
 *      securityScheme="API Token",
 *      type="apiKey",
 *      in="header",
 *      name="x-api-key"
 * )
 */

<?php

namespace App\Swagger\Resources;

/**
 * @OA\Get(
 *      path="/entries",
 *      operationId="getEntriesList",
 *      tags={"Entries"},
 *      summary="Returns a list of catalogue entries",
 *      description="Returns a list of catalogue entries",
 *      security={{"API Token" : {}}},
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/EntriesResource")
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 *     )
 */

 /**
  * @OA\Get(
  *      path="/entries/{id}",
  *      operationId="getEntryById",
  *      tags={"Entries"},
  *      summary="Returns a catalogue entry",
  *      description="Returns catalogue entry data",
  *      security={{"API Token" : {}}},
  *      @OA\Parameter(
  *          name="id",
  *          description="Entry id",
  *          required=true,
  *          in="path",
  *          @OA\Schema(
  *              type="integer"
  *          )
  *      ),
  *      @OA\Response(
  *          response=200,
  *          description="Successful operation",
  *          @OA\JsonContent(ref="#/components/schemas/EntryResource")
  *       ),
  *      @OA\Response(
  *          response=400,
  *          description="Bad Request"
  *      ),
  *      @OA\Response(
  *          response=401,
  *          description="Unauthenticated",
  *      ),
  *      @OA\Response(
  *          response=403,
  *          description="Forbidden"
  *      ),
  *      @OA\Response(
  *          response=404,
  *          description="Entry does not exist"
  *      )
  * )
  */

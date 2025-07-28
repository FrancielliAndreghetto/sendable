<?php

namespace App\UseCases\Auth\ApiKeys;

use App\DTOs\Auth\ApiKeys\CreateApiKeyDTO;
use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CreateApiKeyUseCase
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(CreateApiKeyDTO $dto): Model
    {
        $apiKey = $this->apiKeyRepository->create([
            'partner_id' => $dto->partner_id,
            'name' => $dto->name,
            'user_id' => $dto->user_id ?? null,
        ]);

        if (!$apiKey || !$apiKey->exists) {
            throw new Exception('Falha ao salvar Api Key no banco de dados');
        }

        return $apiKey;
    }
}

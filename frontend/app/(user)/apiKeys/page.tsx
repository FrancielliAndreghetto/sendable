"use client";

import { useGetApiKeys } from "@/hooks/api/user/useGetApiKeys";
import LoadingOverlay from "@/components/LoadingOverlay";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";

export default function Page() {
  const { data: apiKeysData, isLoading, error } = useGetApiKeys();

  if (isLoading) {
    return <LoadingOverlay loading />;
  }

  if (error) {
    return (
      <div className="overflow-hidden px-4 md:px-6 lg:px-8">
        <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            Erro ao carregar chaves de API: {error.message}
          </div>
        </div>
      </div>
    );
  }

  const apiKeys = apiKeysData?.data || [];

  return (
    <div className="overflow-hidden px-4 md:px-6 lg:px-8">
      <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
        <div className="flex items-center justify-between gap-4">
          <div className="space-y-1">
            <h1 className="text-2xl font-semibold">Chaves de API</h1>
            <p className="text-sm text-muted-foreground">
              Visualize e gerencie suas chaves de API.
            </p>
          </div>
          <div>
            <button className="bg-gradient-to-r from-primary/40 to-primary/20 hover:from-primary/60 hover:to-primary/30 text-white font-bold py-2 px-4 rounded">
              Gerar nova chave de API
            </button>
          </div>
        </div>
        <div className="bg-gradient-to-b from-sidebar/60 to-sidebar p-3 rounded-2xl border border-border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nome</TableHead>
                <TableHead>Api Key</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Criado em</TableHead>
                <TableHead>Atualizado em</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {apiKeys.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={5} className="text-center text-muted-foreground py-8">
                    Nenhuma chave de API encontrada
                  </TableCell>
                </TableRow>
              ) : (
                apiKeys.map((apiKey) => (
                  <TableRow key={apiKey.id}>
                    <TableCell className="font-medium">{apiKey.name}</TableCell>
                    <TableCell className="font-mono text-sm">
                      {apiKey.key.substring(0, 20)}...
                    </TableCell>
                    <TableCell>
                      <Badge variant={apiKey.status === 'active' ? 'default' : 'secondary'}>
                        {apiKey.status === 'active' ? 'Ativo' : 'Inativo'}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      {apiKey.createdAt ? new Date(apiKey.createdAt).toLocaleDateString('pt-BR') : '-'}
                    </TableCell>
                    <TableCell>
                      {apiKey.updatedAt ? new Date(apiKey.updatedAt).toLocaleDateString('pt-BR') : '-'}
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </div>
      </div>
    </div>
  );
}

'use client'

import { RiInstanceLine, RiDeleteBinLine, RiPencilLine } from "@remixicon/react";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import useGetInstances from "@/hooks/api/user/useGetInstances";
import useDeleteInstance from "@/hooks/api/user/useDeleteInstance";
import { IInstance } from "@/types";

export function InstancesContent() {
  const { data, isLoading, error, refetch } = useGetInstances();
  const { mutate: deleteInstance, isPending: isDeleting } = useDeleteInstance();

  const handleDeleteInstance = (instanceId: string) => {
    if (confirm('Deseja realmente deletar esta instância?')) {
      deleteInstance(instanceId, {
        onSuccess: () => {
          refetch();
        },
      });
    }
  };

  const handleEditInstance = (instance: IInstance) => {
    // TODO: Abrir modal de edição
    console.log('Editar instância:', instance);
  };

  const getStatusVariant = (status: string) => {
    switch (status) {
      case 'connected': return 'default';
      case 'disconnected': return 'destructive';
      case 'connecting': return 'secondary';
      default: return 'secondary';
    }
  };

  const getStatusLabel = (status: string) => {
    switch (status) {
      case 'connected': return 'Conectada';
      case 'disconnected': return 'Desconectada';
      case 'connecting': return 'Conectando';
      default: return status;
    }
  };

  const getPlatformLabel = (platform: string) => {
    switch (platform) {
      case 'whatsapp': return 'WhatsApp';
      case 'telegram': return 'Telegram';
      case 'instagram': return 'Instagram';
      default: return platform;
    }
  };

  if (isLoading) {
    return (
      <div className="p-6">
        <div className="flex items-center justify-center h-64">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="p-6">
        <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
          Erro ao carregar instâncias: {error.message}
        </div>
      </div>
    );
  }

  const instances = data?.data || [];

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <div className="flex items-center gap-2">
          <RiInstanceLine size={22} className="text-muted-foreground" />
          <h1 className="text-2xl font-bold">Instâncias</h1>
        </div>
        <Button>
          Nova instância
        </Button>
      </div>

      {instances.length === 0 ? (
        <div className="text-center py-12 text-muted-foreground">
          Nenhuma instância encontrada
        </div>
      ) : (
        <div className="border rounded-lg">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nome</TableHead>
                <TableHead>Número</TableHead>
                <TableHead>Plataforma</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Ações</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {instances.map((instance) => (
                <TableRow key={instance.id}>
                  <TableCell className="font-medium">{instance.name}</TableCell>
                  <TableCell>{instance.phone}</TableCell>
                  <TableCell>{getPlatformLabel(instance.platform)}</TableCell>
                  <TableCell>
                    <Badge variant={getStatusVariant(instance.status)}>
                      {getStatusLabel(instance.status)}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex gap-2 justify-end">
                      <Button 
                        variant="outline" 
                        size="sm"
                        onClick={() => handleEditInstance(instance)}
                        disabled={isDeleting}
                      >
                        <RiPencilLine className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="destructive" 
                        size="sm"
                        onClick={() => handleDeleteInstance(instance.id!)}
                        disabled={isDeleting}
                      >
                        <RiDeleteBinLine className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </div>
      )}
    </div>
  );
}



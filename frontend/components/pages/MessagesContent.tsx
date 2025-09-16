'use client'

import { RiDeleteBinLine, RiPencilLine } from "@remixicon/react";
import { ConfigurableDialog } from "@/components/dialogs/ConfigurableDialog";
import { getMessageDialogConfigs } from "@/config/messageDialogs";
import { useDialogHandlers, messageAPI } from "@/hooks/useDialogHandlers";
import { useGetMessages } from "@/hooks/api/user/useGetMessages";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import LoadingOverlay from "@/components/LoadingOverlay";

export function MessagesContent() {
  const { isLoading, error, createHandler, clearError } = useDialogHandlers();
  const { data: messagesData, isLoading: isLoadingMessages, error: messagesError, refetch: refetchMessages } = useGetMessages();
  
  // Obter configurações dos dialogs
  const messageDialogs = getMessageDialogConfigs();

  // Handlers para diferentes tipos de mensagem
  const handleCreateMessage = createHandler(messageAPI.create);
  const handleCreateScheduledMessage = createHandler(messageAPI.create);
  const handleCreateRecurringMessage = createHandler(messageAPI.create);
  const handleEditMessage = createHandler((data) => messageAPI.update('message-id', data));

  // Deletar mensagem
  const handleDeleteMessage = async (id?: string) => {
    if (!id) return;
    if (!confirm('Deseja realmente deletar esta mensagem?')) return;
    try {
      await messageAPI.delete(id);
      refetchMessages?.();
    } catch (err) {
      console.error('Erro ao deletar mensagem:', err);
      alert('Erro ao deletar mensagem');
    }
  };

  const getStatusBadgeVariant = (status: string) => {
    switch (status) {
      case 'sent': return 'destructive';
      case 'scheduled': return 'destructive';
      case 'recurring': return 'destructive';
      case 'pending': return 'destructive';
      case 'failed': return 'destructive';
      default: return 'default';
    }
  };

  const getTypeLabel = (type: string) => {
    switch (type) {
      case 'simple': return 'Simples';
      case 'scheduled': return 'Agendada';
      case 'recurring': return 'Recorrente';
      default: return type;
    }
  };

  const getStatusLabel = (status: string) => {
    switch (status) {
      case 'sent': return 'Enviada';
      case 'scheduled': return 'Agendada';
      case 'recurring': return 'Recorrente';
      case 'pending': return 'Pendente';
      case 'failed': return 'Falhou';
      default: return status;
    }
  };

  if (isLoadingMessages) {
    return <LoadingOverlay loading />;
  }

  if (messagesError) {
    return (
      <div className="p-6">
        <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
          Erro ao carregar mensagens: {messagesError.message}
        </div>
      </div>
    );
  }

  const messages = messagesData?.data || [];

  return (
    <div className="p-6">
      {/* Header com botões de ação */}
      <div className="flex justify-between items-center mb-6">
        <div>
          <h1 className="text-2xl font-bold">Mensagens WhatsApp</h1>
          <p className="text-muted-foreground">Gerencie suas mensagens e campanhas</p>
        </div>
        
        <div className="flex gap-2">
          <ConfigurableDialog 
            config={messageDialogs.createScheduled}
            onSubmit={handleCreateScheduledMessage}
            isLoading={isLoading}
          />
        </div>
      </div>

      {/* Exibir erro se houver */}
      {error && (
        <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
          <div className="flex justify-between items-center">
            <span>{error}</span>
            <Button variant="ghost" size="sm" onClick={clearError}>
              ✕
            </Button>
          </div>
        </div>
      )}

      {/* Tabela de mensagens */}
      <div className="border rounded-lg">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Data/Hora</TableHead>
              <TableHead>Contato</TableHead>
              <TableHead>Instância</TableHead>
              <TableHead>Conteúdo</TableHead>
              <TableHead>Tipo</TableHead>
              <TableHead>Status</TableHead>
              <TableHead className="text-right">Ações</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {messages.length === 0 ? (
              <TableRow>
                <TableCell colSpan={7} className="text-center text-muted-foreground py-8">
                  Nenhuma mensagem encontrada
                </TableCell>
              </TableRow>
            ) : (
              messages.map((message) => (
                <TableRow key={message.id}>
                  <TableCell className="font-medium">
                    {message.created_at ? new Date(message.created_at).toLocaleString('pt-BR') : '-'}
                  </TableCell>
                  <TableCell>{message.contact}</TableCell>
                  <TableCell>{message.instance}</TableCell>
                  <TableCell className="max-w-xs truncate" title={message.content}>
                    {message.content}
                  </TableCell>
                  <TableCell>
                    <Badge variant="outline">{getTypeLabel(message.type)}</Badge>
                  </TableCell>
                  <TableCell>
                    <Badge variant={getStatusBadgeVariant(message.status)}>
                      {getStatusLabel(message.status)}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex gap-2 justify-end">
                      <ConfigurableDialog 
                        config={{
                          ...messageDialogs.edit,
                          triggerLabel: ''
                        }}
                        onSubmit={async (data) => {
                          try {
                            await messageAPI.update(message.id || '', data);
                            refetchMessages?.();
                          } catch (err) {
                            console.error('Erro ao editar mensagem:', err);
                            alert('Erro ao editar mensagem');
                          }
                        }}
                        isLoading={isLoading}
                      />
                      <Button 
                        variant="destructive" 
                        size="sm"
                        onClick={() => handleDeleteMessage(message.id)}
                        disabled={isLoading}
                      >
                        <RiDeleteBinLine className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </div>

      {/* Loading overlay */}
      {isLoading && (
        <LoadingOverlay loading />
      )}
    </div>
  );
}

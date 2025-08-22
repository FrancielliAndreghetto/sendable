'use client'

import { ConfigurableDialog } from "@/components/dialogs/ConfigurableDialog";
import { getMessageDialogConfigs } from "@/config/messageDialogs";
import { useDialogHandlers, messageAPI } from "@/hooks/useDialogHandlers";
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

export function MessagesContent() {
  const { isLoading, error, createHandler, clearError } = useDialogHandlers();
  
  // Obter configurações dos dialogs
  const messageDialogs = getMessageDialogConfigs();

  // Handlers para diferentes tipos de mensagem
  const handleCreateMessage = createHandler(messageAPI.create);
  const handleCreateScheduledMessage = createHandler(messageAPI.create);
  const handleCreateRecurringMessage = createHandler(messageAPI.create);
  const handleEditMessage = createHandler((data) => messageAPI.update('message-id', data));

  // Dados mockados das mensagens
  const messages = [
    {
      id: "1",
      date: "10/07/2025 14:30",
      contact: "+55 51 98318-6148",
      platform: "Whatsapp",
      campaign: "Campanha de Marketing",
      status: "Enviada",
      type: "Simples"
    },
    {
      id: "2", 
      date: "25/07/2025 09:15",
      contact: "+55 51 98318-6148",
      platform: "Whatsapp",
      campaign: "Campanha de Vendas",
      status: "Agendada",
      type: "Agendada"
    },
    {
      id: "3",
      date: "28/07/2025 11:45",
      contact: "+55 51 98318-6148",
      platform: "Whatsapp", 
      campaign: "Atendimento ao Cliente",
      status: "Recorrente",
      type: "Recorrente"
    },
    {
      id: "4",
      date: "29/07/2025 16:20",
      contact: "+55 51 98318-6148",
      platform: "Whatsapp",
      campaign: "Próximo Lançamento",
      status: "Pendente",
      type: "Agendada"
    },
    {
      id: "5",
      date: "31/07/2025 08:00",
      contact: "+55 51 98318-6148",
      platform: "Whatsapp",
      campaign: "Black Friday",
      status: "Enviada",
      type: "Simples"
    }
  ];

  const getStatusBadgeVariant = (status: string) => {
    switch (status) {
      case 'Enviada': return 'default';
      case 'Agendada': return 'secondary';
      case 'Recorrente': return 'outline';
      case 'Pendente': return 'destructive';
      default: return 'default';
    }
  };

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
            config={messageDialogs.createSimple}
            onSubmit={handleCreateMessage}
            isLoading={isLoading}
          />
          
          <ConfigurableDialog 
            config={messageDialogs.createScheduled}
            onSubmit={handleCreateScheduledMessage}
            isLoading={isLoading}
          />
          
          <ConfigurableDialog 
            config={messageDialogs.createRecurring}
            onSubmit={handleCreateRecurringMessage}
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
              <TableHead>Plataforma</TableHead>
              <TableHead>Campanha</TableHead>
              <TableHead>Tipo</TableHead>
              <TableHead>Status</TableHead>
              <TableHead className="text-right">Ações</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {messages.map((message) => (
              <TableRow key={message.id}>
                <TableCell className="font-medium">{message.date}</TableCell>
                <TableCell>{message.contact}</TableCell>
                <TableCell>{message.platform}</TableCell>
                <TableCell>{message.campaign}</TableCell>
                <TableCell>
                  <Badge variant="outline">{message.type}</Badge>
                </TableCell>
                <TableCell>
                  <Badge variant={getStatusBadgeVariant(message.status)}>
                    {message.status}
                  </Badge>
                </TableCell>
                <TableCell className="text-right">
                  <div className="flex gap-2 justify-end">
                    <ConfigurableDialog 
                      config={{
                        ...messageDialogs.edit,
                        triggerLabel: 'Editar'
                      }}
                      onSubmit={handleEditMessage}
                      isLoading={isLoading}
                    />
                    <Button 
                      variant="destructive" 
                      size="sm"
                      onClick={() => {
                        if (confirm('Deseja realmente deletar esta mensagem?')) {
                          createHandler(() => messageAPI.delete(message.id))({});
                        }
                      }}
                      disabled={isLoading}
                    >
                      Deletar
                    </Button>
                  </div>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </div>

      {/* Loading overlay */}
      {isLoading && (
        <div className="fixed inset-0 bg-black/20 flex items-center justify-center z-50">
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <div className="flex items-center gap-3">
              <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
              <span>Processando...</span>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

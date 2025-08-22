// Exemplo de como usar os handlers em qualquer página
'use client'

import { ConfigurableDialog } from "@/components/dialogs/ConfigurableDialog";
import { useDialogHandlers, messageAPI, contactAPI } from "@/hooks/useDialogHandlers";
import { MESSAGE_DIALOG_CONFIGS } from "@/config/messageDialogs";

export function ExampleUsage() {
  // 1. Use o hook para obter handlers e loading state
  const { isLoading, error, createHandler, clearError } = useDialogHandlers();

  // 2. Crie handlers específicos para cada ação
  const handleCreateMessage = createHandler(messageAPI.create);
  const handleCreateContact = createHandler(contactAPI.create);
  const handleEditMessage = createHandler((data) => messageAPI.update('message-id', data));

  return (
    <div className="p-6 space-y-4">
      <h1 className="text-2xl font-bold">Exemplo de Uso dos Handlers</h1>
      
      {/* Exibir erro se houver */}
      {error && (
        <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
          <div className="flex justify-between items-center">
            <span>{error}</span>
            <button onClick={clearError} className="text-red-500 hover:text-red-700">
              ✕
            </button>
          </div>
        </div>
      )}

      <div className="flex gap-4 flex-wrap">
        {/* Dialog para mensagem simples */}
        <ConfigurableDialog 
          config={MESSAGE_DIALOG_CONFIGS.createSimple}
          onSubmit={handleCreateMessage}
          isLoading={isLoading}
        />
        
        {/* Dialog para mensagem agendada */}
        <ConfigurableDialog 
          config={MESSAGE_DIALOG_CONFIGS.createScheduled}
          onSubmit={handleCreateMessage}
          isLoading={isLoading}
        />
        
        {/* Dialog para mensagem recorrente */}
        <ConfigurableDialog 
          config={MESSAGE_DIALOG_CONFIGS.createRecurring}
          onSubmit={handleCreateMessage}
          isLoading={isLoading}
        />

        {/* Dialog para criar contato */}
        <ConfigurableDialog 
          config={{
            title: 'Novo Contato',
            triggerLabel: 'Adicionar Contato',
            submitLabel: 'Criar',
            fields: [
              {
                name: 'name',
                label: 'Nome',
                type: 'text' as const,
                placeholder: 'Nome do contato',
                required: true
              },
              {
                name: 'phone',
                label: 'Telefone',
                type: 'text' as const,
                placeholder: '+55 11 99999-9999',
                required: true
              }
            ]
          }}
          onSubmit={handleCreateContact}
          isLoading={isLoading}
        />
      </div>

      {/* Loading indicator global */}
      {isLoading && (
        <div className="fixed inset-0 bg-black/20 flex items-center justify-center z-50">
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <div className="flex items-center gap-3">
              <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
              <span>Processando operação...</span>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

// Como usar em outras páginas:
export function ContactsPageExample() {
  const { isLoading, createHandler } = useDialogHandlers();
  
  const handleCreateContact = createHandler(contactAPI.create);
  
  return (
    <div>
      <ConfigurableDialog 
        config={{
          title: 'Novo Contato',
          triggerLabel: 'Adicionar',
          fields: [
            { name: 'name', label: 'Nome', required: true },
            { name: 'phone', label: 'Telefone', required: true }
          ]
        }}
        onSubmit={handleCreateContact}
        isLoading={isLoading}
      />
    </div>
  );
}

export function InstancesPageExample() {
  const { isLoading, createHandler } = useDialogHandlers();
  
  const handleCreateInstance = createHandler(async (data) => {
    // Sua API call aqui
    await fetch('/api/instances', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
  });
  
  return (
    <div>
      <ConfigurableDialog 
        config={{
          title: 'Nova Instância',
          triggerLabel: 'Criar Instância',
          fields: [
            { name: 'name', label: 'Nome', required: true },
            { name: 'phone', label: 'Telefone', required: true },
            { name: 'token', label: 'Token' }
          ]
        }}
        onSubmit={handleCreateInstance}
        isLoading={isLoading}
      />
    </div>
  );
}

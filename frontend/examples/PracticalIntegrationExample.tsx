// Integração prática com as páginas do sistema
'use client'

import { Button } from "@/components/ui/button";
import { ConfigurableDialog } from "@/components/dialogs/ConfigurableDialog";

export function PracticalIntegrationExample() {
  // Exemplo de configuração de dialog simples
  const newMessageConfig = {
    title: "Nova Mensagem",
    description: "Envie uma nova mensagem para o WhatsApp",
    triggerLabel: "Nova Mensagem",
    triggerIcon: <i className="ri-message-line" />,
    triggerVariant: "default" as const,
    fields: [
      {
        name: "recipient",
        label: "Destinatário",
        type: "text" as const,
        placeholder: "Digite o número ou nome",
        required: true
      },
      {
        name: "message",
        label: "Mensagem",
        type: "textarea" as const,
        placeholder: "Digite sua mensagem...",
        required: true
      }
    ],
    submitLabel: "Enviar"
  };

  const scheduleMessageConfig = {
    title: "Agendar Mensagem",
    description: "Agende uma mensagem para ser enviada posteriormente",
    triggerLabel: "Agendar",
    triggerIcon: <i className="ri-calendar-schedule-line" />,
    triggerVariant: "outline" as const,
    fields: [
      {
        name: "recipient",
        label: "Destinatário",
        type: "text" as const,
        placeholder: "Digite o número ou nome",
        required: true
      },
      {
        name: "message",
        label: "Mensagem",
        type: "textarea" as const,
        placeholder: "Digite sua mensagem...",
        required: true
      },
      {
        name: "scheduleDate",
        label: "Data/Hora",
        type: "text" as const,
        placeholder: "DD/MM/AAAA HH:MM",
        required: true
      }
    ],
    submitLabel: "Agendar"
  };

  const handleDialogSubmit = async (data: Record<string, string>) => {
    console.log('Dialog data:', data);
    // Simular delay de API
    await new Promise(resolve => setTimeout(resolve, 2000));
  };

  return (
    <div className="p-6 space-y-8">
      <h1 className="text-2xl font-bold">Integração Prática - Usando Botões com Ícones</h1>

      {/* Header Actions */}
      <section className="space-y-4">
        <h2 className="text-lg font-semibold">Header de Página</h2>
        <div className="flex items-center justify-between p-4 border rounded-lg bg-card">
          <div>
            <h3 className="font-medium">Mensagens WhatsApp</h3>
            <p className="text-sm text-muted-foreground">Gerencie suas mensagens</p>
          </div>
          
          <div className="flex gap-2">
            {/* Usando o ConfigurableDialog com ícones */}
            <ConfigurableDialog
              config={newMessageConfig}
              onSubmit={handleDialogSubmit}
            />
            
            <ConfigurableDialog
              config={scheduleMessageConfig}
              onSubmit={handleDialogSubmit}
            />
            
            {/* Botões adicionais */}
            <Button 
              icon={<i className="ri-download-line" />}
              variant="outline"
            >
              Exportar
            </Button>
            
            <Button 
              icon={<i className="ri-settings-line" />}
              iconOnly
              variant="ghost"
              title="Configurações"
            />
          </div>
        </div>
      </section>

      {/* Table Actions */}
      <section className="space-y-4">
        <h2 className="text-lg font-semibold">Ações de Tabela</h2>
        <div className="border rounded-lg">
          {/* Table Header */}
          <div className="flex items-center justify-between p-4 border-b bg-muted/50">
            <div className="flex items-center gap-4">
              <h3 className="font-medium">Lista de Mensagens</h3>
              <span className="text-sm text-muted-foreground">245 mensagens</span>
            </div>
            
            <div className="flex gap-2">
              <Button 
                icon={<i className="ri-filter-line" />}
                variant="outline"
                size="sm"
              >
                Filtrar
              </Button>
              
              <Button 
                icon={<i className="ri-refresh-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Atualizar"
              />
            </div>
          </div>

          {/* Sample Table Row */}
          <div className="p-4 border-b">
            <div className="flex items-center justify-between">
              <div className="flex-1">
                <div className="font-medium">João Silva</div>
                <div className="text-sm text-muted-foreground">+55 11 99999-9999</div>
                <div className="text-sm">Olá, gostaria de mais informações...</div>
              </div>
              
              <div className="flex gap-1">
                <Button 
                  icon={<i className="ri-reply-line" />}
                  iconOnly
                  variant="ghost"
                  size="sm"
                  title="Responder"
                />
                
                <Button 
                  icon={<i className="ri-forward-line" />}
                  iconOnly
                  variant="ghost"
                  size="sm"
                  title="Encaminhar"
                />
                
                <Button 
                  icon={<i className="ri-more-line" />}
                  iconOnly
                  variant="ghost"
                  size="sm"
                  title="Mais opções"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Quick Actions Panel */}
      <section className="space-y-4">
        <h2 className="text-lg font-semibold">Painel de Ações Rápidas</h2>
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <Button 
            className="h-24 flex-col gap-2"
            variant="outline"
            icon={<i className="ri-message-2-line text-2xl" />}
          >
            <span className="text-xs">Nova Mensagem</span>
          </Button>
          
          <Button 
            className="h-24 flex-col gap-2"
            variant="outline"
            icon={<i className="ri-calendar-schedule-line text-2xl" />}
          >
            <span className="text-xs">Agendar</span>
          </Button>
          
          <Button 
            className="h-24 flex-col gap-2"
            variant="outline"
            icon={<i className="ri-contacts-line text-2xl" />}
          >
            <span className="text-xs">Contatos</span>
          </Button>
          
          <Button 
            className="h-24 flex-col gap-2"
            variant="outline"
            icon={<i className="ri-bar-chart-line text-2xl" />}
          >
            <span className="text-xs">Relatórios</span>
          </Button>
        </div>
      </section>

      {/* Status Indicators */}
      <section className="space-y-4">
        <h2 className="text-lg font-semibold">Indicadores de Status</h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div className="p-4 border rounded-lg">
            <div className="flex items-center justify-between mb-2">
              <span className="text-sm font-medium">Mensagens Enviadas</span>
              <Button 
                icon={<i className="ri-check-double-line text-green-600" />}
                iconOnly
                variant="ghost"
                size="sm"
              />
            </div>
            <div className="text-2xl font-bold">1,234</div>
          </div>
          
          <div className="p-4 border rounded-lg">
            <div className="flex items-center justify-between mb-2">
              <span className="text-sm font-medium">Pendentes</span>
              <Button 
                icon={<i className="ri-time-line text-yellow-600" />}
                iconOnly
                variant="ghost"
                size="sm"
              />
            </div>
            <div className="text-2xl font-bold">45</div>
          </div>
          
          <div className="p-4 border rounded-lg">
            <div className="flex items-center justify-between mb-2">
              <span className="text-sm font-medium">Falharam</span>
              <Button 
                icon={<i className="ri-error-warning-line text-red-600" />}
                iconOnly
                variant="ghost"
                size="sm"
              />
            </div>
            <div className="text-2xl font-bold">3</div>
          </div>
        </div>
      </section>

      {/* Chat Interface */}
      <section className="space-y-4">
        <h2 className="text-lg font-semibold">Interface de Chat</h2>
        <div className="border rounded-lg h-96 flex flex-col">
          {/* Chat Header */}
          <div className="flex items-center justify-between p-3 border-b bg-muted/50">
            <div className="flex items-center gap-3">
              <div className="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                <i className="ri-user-line text-primary-foreground text-sm" />
              </div>
              <div>
                <div className="font-medium text-sm">João Silva</div>
                <div className="text-xs text-muted-foreground">Online</div>
              </div>
            </div>
            
            <div className="flex gap-1">
              <Button 
                icon={<i className="ri-phone-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Ligar"
              />
              
              <Button 
                icon={<i className="ri-video-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Videochamada"
              />
              
              <Button 
                icon={<i className="ri-more-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Mais opções"
              />
            </div>
          </div>
          
          {/* Chat Messages Area */}
          <div className="flex-1 p-4 space-y-4 overflow-y-auto">
            <div className="flex justify-end">
              <div className="bg-primary text-primary-foreground p-3 rounded-lg max-w-xs">
                Olá! Como posso ajudar?
              </div>
            </div>
            
            <div className="flex">
              <div className="bg-muted p-3 rounded-lg max-w-xs">
                Gostaria de mais informações sobre o produto.
              </div>
            </div>
          </div>
          
          {/* Chat Input */}
          <div className="p-3 border-t">
            <div className="flex gap-2">
              <Button 
                icon={<i className="ri-attachment-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Anexar arquivo"
              />
              
              <div className="flex-1 bg-muted rounded-lg px-3 py-2 text-sm">
                Digite sua mensagem...
              </div>
              
              <Button 
                icon={<i className="ri-emoji-sticker-line" />}
                iconOnly
                variant="ghost"
                size="sm"
                title="Emoji"
              />
              
              <Button 
                icon={<i className="ri-send-plane-line" />}
                iconOnly
                title="Enviar"
              />
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}

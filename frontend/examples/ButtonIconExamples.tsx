// Exemplos de como usar o Button com ícones do Remix Icon
'use client'

import { Button } from "@/components/ui/button";

export function ButtonIconExamples() {
  return (
    <div className="p-6 space-y-6">
      <h1 className="text-2xl font-bold">Button com Ícones - Exemplos</h1>

      {/* Botões com ícone à esquerda */}
      <div className="space-y-4">
        <h2 className="text-lg font-semibold">Ícone à Esquerda (Padrão)</h2>
        <div className="flex gap-4 flex-wrap">
          <Button 
            icon={<i className="ri-add-line" />}
          >
            Adicionar
          </Button>

          <Button 
            variant="outline"
            icon={<i className="ri-edit-line" />}
          >
            Editar
          </Button>

          <Button 
            variant="destructive"
            icon={<i className="ri-delete-bin-line" />}
          >
            Deletar
          </Button>

          <Button 
            variant="secondary"
            icon={<i className="ri-download-line" />}
          >
            Download
          </Button>

          <Button 
            variant="ghost"
            icon={<i className="ri-share-line" />}
          >
            Compartilhar
          </Button>
        </div>
      </div>

      {/* Botões com ícone à direita */}
      <div className="space-y-4">
        <h2 className="text-lg font-semibold">Ícone à Direita</h2>
        <div className="flex gap-4 flex-wrap">
          <Button 
            icon={<i className="ri-arrow-right-line" />}
            iconPosition="right"
          >
            Próximo
          </Button>

          <Button 
            variant="outline"
            icon={<i className="ri-external-link-line" />}
            iconPosition="right"
          >
            Abrir Link
          </Button>

          <Button 
            variant="secondary"
            icon={<i className="ri-send-plane-line" />}
            iconPosition="right"
          >
            Enviar
          </Button>
        </div>
      </div>

      {/* Botões somente ícone */}
      <div className="space-y-4">
        <h2 className="text-lg font-semibold">Somente Ícone</h2>
        <div className="flex gap-4 flex-wrap">
          <Button 
            icon={<i className="ri-search-line" />}
            iconOnly
            variant="outline"
            title="Pesquisar"
          />

          <Button 
            icon={<i className="ri-settings-line" />}
            iconOnly
            variant="ghost"
            title="Configurações"
          />

          <Button 
            icon={<i className="ri-notification-line" />}
            iconOnly
            variant="secondary"
            title="Notificações"
          />

          <Button 
            icon={<i className="ri-user-line" />}
            iconOnly
            title="Perfil"
          />
        </div>
      </div>

      {/* Diferentes tamanhos */}
      <div className="space-y-4">
        <h2 className="text-lg font-semibold">Diferentes Tamanhos</h2>
        <div className="flex gap-4 items-center flex-wrap">
          <Button 
            size="sm"
            icon={<i className="ri-heart-line" />}
          >
            Pequeno
          </Button>

          <Button 
            size="default"
            icon={<i className="ri-heart-line" />}
          >
            Padrão
          </Button>

          <Button 
            size="lg"
            icon={<i className="ri-heart-line" />}
          >
            Grande
          </Button>

          {/* Ícones somente em diferentes tamanhos */}
          <Button 
            size="sm"
            icon={<i className="ri-heart-line text-xs" />}
            iconOnly
            title="Pequeno"
          />

          <Button 
            icon={<i className="ri-heart-line" />}
            iconOnly
            title="Padrão"
          />

          <Button 
            size="lg"
            icon={<i className="ri-heart-line text-lg" />}
            iconOnly
            title="Grande"
          />
        </div>
      </div>

      {/* Casos de uso práticos */}
      <div className="space-y-4">
        <h2 className="text-lg font-semibold">Casos de Uso Práticos</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          {/* WhatsApp Messages */}
          <div className="p-4 border rounded-lg space-y-2">
            <h3 className="font-medium">Mensagens WhatsApp</h3>
            <div className="space-y-2">
              <Button 
                className="w-full"
                icon={<i className="ri-message-line" />}
              >
                Nova Mensagem
              </Button>
              
              <Button 
                variant="outline"
                className="w-full"
                icon={<i className="ri-calendar-schedule-line" />}
              >
                Agendar
              </Button>
              
              <Button 
                variant="secondary"
                className="w-full"
                icon={<i className="ri-repeat-line" />}
              >
                Recorrente
              </Button>
            </div>
          </div>

          {/* Contacts */}
          <div className="p-4 border rounded-lg space-y-2">
            <h3 className="font-medium">Contatos</h3>
            <div className="space-y-2">
              <Button 
                className="w-full"
                icon={<i className="ri-user-add-line" />}
              >
                Adicionar Contato
              </Button>
              
              <Button 
                variant="outline"
                className="w-full"
                icon={<i className="ri-upload-line" />}
              >
                Importar
              </Button>
              
              <Button 
                variant="ghost"
                className="w-full"
                icon={<i className="ri-download-line" />}
              >
                Exportar
              </Button>
            </div>
          </div>

          {/* Actions */}
          <div className="p-4 border rounded-lg space-y-2">
            <h3 className="font-medium">Ações</h3>
            <div className="flex gap-2">
              <Button 
                icon={<i className="ri-edit-line" />}
                iconOnly
                variant="outline"
                title="Editar"
              />
              
              <Button 
                icon={<i className="ri-eye-line" />}
                iconOnly
                variant="ghost"
                title="Visualizar"
              />
              
              <Button 
                icon={<i className="ri-delete-bin-line" />}
                iconOnly
                variant="destructive"
                title="Deletar"
              />
              
              <Button 
                icon={<i className="ri-more-line" />}
                iconOnly
                variant="ghost"
                title="Mais opções"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

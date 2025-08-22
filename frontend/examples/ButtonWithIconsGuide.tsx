// Como usar o Button com ícones do Remix Icon - Guia Prático
'use client'

import { Button } from "@/components/ui/button";

export function ButtonWithIconsGuide() {
  return (
    <div className="p-6 space-y-8">
      <div className="space-y-2">
        <h1 className="text-3xl font-bold">Button com Ícones - Guia Prático</h1>
        <p className="text-muted-foreground">Todas as formas de usar ícones do Remix Icon nos botões</p>
      </div>

      {/* Exemplos básicos */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">1. Exemplos Básicos</h2>
        <div className="flex gap-4 flex-wrap">
          {/* Ícone à esquerda (padrão) */}
          <Button icon={<i className="ri-add-line" />}>
            Adicionar
          </Button>

          {/* Ícone à direita */}
          <Button 
            icon={<i className="ri-arrow-right-line" />}
            iconPosition="right"
          >
            Próximo
          </Button>

          {/* Somente ícone */}
          <Button 
            icon={<i className="ri-settings-line" />}
            iconOnly
            title="Configurações"
          />
        </div>
      </section>

      {/* Diferentes variantes */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">2. Diferentes Variantes</h2>
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
          <Button 
            variant="default"
            icon={<i className="ri-heart-line" />}
          >
            Default
          </Button>

          <Button 
            variant="destructive"
            icon={<i className="ri-delete-bin-line" />}
          >
            Delete
          </Button>

          <Button 
            variant="outline"
            icon={<i className="ri-edit-line" />}
          >
            Edit
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
            Share
          </Button>

          <Button 
            variant="link"
            icon={<i className="ri-external-link-line" />}
          >
            Link
          </Button>
        </div>
      </section>

      {/* Botões de ação comuns */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">3. Ações Comuns</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          
          {/* WhatsApp Actions */}
          <div className="space-y-2">
            <h3 className="font-medium text-sm text-muted-foreground">WhatsApp</h3>
            <div className="space-y-2">
              <Button 
                className="w-full"
                icon={<i className="ri-message-line" />}
                variant="default"
              >
                Nova Mensagem
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-calendar-schedule-line" />}
                variant="outline"
              >
                Agendar
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-repeat-line" />}
                variant="secondary"
              >
                Recorrente
              </Button>
            </div>
          </div>

          {/* File Actions */}
          <div className="space-y-2">
            <h3 className="font-medium text-sm text-muted-foreground">Arquivos</h3>
            <div className="space-y-2">
              <Button 
                className="w-full"
                icon={<i className="ri-upload-line" />}
                variant="outline"
              >
                Upload
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-download-line" />}
                variant="outline"
              >
                Download
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-file-copy-line" />}
                variant="ghost"
              >
                Duplicar
              </Button>
            </div>
          </div>

          {/* User Actions */}
          <div className="space-y-2">
            <h3 className="font-medium text-sm text-muted-foreground">Usuário</h3>
            <div className="space-y-2">
              <Button 
                className="w-full"
                icon={<i className="ri-user-add-line" />}
                variant="default"
              >
                Adicionar
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-user-settings-line" />}
                variant="outline"
              >
                Configurar
              </Button>
              
              <Button 
                className="w-full"
                icon={<i className="ri-logout-box-line" />}
                variant="destructive"
              >
                Sair
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* Toolbar example */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">4. Toolbar de Ações</h2>
        <div className="flex gap-1 p-2 bg-muted rounded-lg w-fit">
          <Button 
            icon={<i className="ri-bold" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Negrito"
          />
          
          <Button 
            icon={<i className="ri-italic" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Itálico"
          />
          
          <Button 
            icon={<i className="ri-underline" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Sublinhado"
          />
          
          <div className="w-px bg-border mx-1" />
          
          <Button 
            icon={<i className="ri-align-left" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Alinhar à esquerda"
          />
          
          <Button 
            icon={<i className="ri-align-center" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Centralizar"
          />
          
          <Button 
            icon={<i className="ri-align-right" />}
            iconOnly
            variant="ghost"
            size="sm"
            title="Alinhar à direita"
          />
        </div>
      </section>

      {/* Floating Action Button */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">5. Floating Action Button</h2>
        <div className="relative">
          <div className="fixed bottom-6 right-6">
            <Button 
              icon={<i className="ri-add-line text-lg" />}
              iconOnly
              size="lg"
              className="rounded-full shadow-lg hover:shadow-xl transition-shadow"
              title="Adicionar novo item"
            />
          </div>
          <p className="text-sm text-muted-foreground">
            Exemplo de FAB (posicionado no canto inferior direito)
          </p>
        </div>
      </section>

      {/* Loading states */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">6. Estados de Loading</h2>
        <div className="flex gap-4 flex-wrap">
          <Button 
            icon={<i className="ri-loader-4-line animate-spin" />}
            disabled
          >
            Carregando...
          </Button>
          
          <Button 
            icon={<i className="ri-check-line" />}
            variant="outline"
            className="text-green-600 border-green-600"
          >
            Concluído
          </Button>
          
          <Button 
            icon={<i className="ri-error-warning-line" />}
            variant="destructive"
          >
            Erro
          </Button>
        </div>
      </section>

      {/* Code examples */}
      <section className="space-y-4">
        <h2 className="text-xl font-semibold">7. Exemplos de Código</h2>
        <div className="bg-muted p-4 rounded-lg space-y-4">
          <div>
            <h4 className="font-medium mb-2">Botão com ícone básico:</h4>
            <code className="text-sm">
              {`<Button icon={<i className="ri-add-line" />}>Adicionar</Button>`}
            </code>
          </div>
          
          <div>
            <h4 className="font-medium mb-2">Ícone à direita:</h4>
            <code className="text-sm">
              {`<Button icon={<i className="ri-arrow-right-line" />} iconPosition="right">Próximo</Button>`}
            </code>
          </div>
          
          <div>
            <h4 className="font-medium mb-2">Somente ícone:</h4>
            <code className="text-sm">
              {`<Button icon={<i className="ri-settings-line" />} iconOnly title="Configurações" />`}
            </code>
          </div>
        </div>
      </section>
    </div>
  );
}

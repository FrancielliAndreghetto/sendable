// Como usar Button com Remix Icons - Tutorial Completo
'use client'

import { Button } from "@/components/ui/button";

export function ButtonIconTutorial() {
  return (
    <div className="max-w-4xl mx-auto p-6 space-y-12">
      {/* Introdução */}
      <div className="text-center space-y-4">
        <h1 className="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
          Botões com Ícones Remix
        </h1>
        <p className="text-xl text-muted-foreground">
          Aprenda a usar ícones do Remix Icons nos botões do seu sistema
        </p>
      </div>

      {/* 1. Configuração Básica */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">1. Configuração Básica</h2>
          <p className="text-muted-foreground">
            Primeiro, certifique-se de ter o Remix Icons instalado e configurado no seu projeto.
          </p>
        </div>
        
        <div className="bg-slate-100 dark:bg-slate-800 p-4 rounded-lg">
          <pre className="text-sm">
{`npm install remixicon
# ou
yarn add remixicon

// No seu CSS global ou layout:
@import 'remixicon/fonts/remixicon.css';`}
          </pre>
        </div>
      </section>

      {/* 2. Uso Básico */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">2. Como Usar Ícones nos Botões</h2>
          <p className="text-muted-foreground">
            O componente Button agora aceita a prop <code className="bg-muted px-1 rounded">icon</code>
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-6">
          {/* Exemplos visuais */}
          <div className="space-y-4">
            <h3 className="font-semibold">Exemplos Visuais:</h3>
            
            <div className="space-y-3">
              <div className="flex items-center gap-3">
                <Button icon={<i className="ri-add-line" />}>
                  Adicionar
                </Button>
                <span className="text-sm text-muted-foreground">Ícone à esquerda (padrão)</span>
              </div>

              <div className="flex items-center gap-3">
                <Button 
                  icon={<i className="ri-arrow-right-line" />}
                  iconPosition="right"
                >
                  Próximo
                </Button>
                <span className="text-sm text-muted-foreground">Ícone à direita</span>
              </div>

              <div className="flex items-center gap-3">
                <Button 
                  icon={<i className="ri-settings-line" />}
                  iconOnly
                  title="Configurações"
                />
                <span className="text-sm text-muted-foreground">Somente ícone</span>
              </div>
            </div>
          </div>

          {/* Código correspondente */}
          <div className="space-y-4">
            <h3 className="font-semibold">Código:</h3>
            
            <div className="bg-slate-100 dark:bg-slate-800 p-4 rounded-lg text-sm">
              <pre>{`// Ícone à esquerda (padrão)
<Button icon={<i className="ri-add-line" />}>
  Adicionar
</Button>

// Ícone à direita
<Button 
  icon={<i className="ri-arrow-right-line" />}
  iconPosition="right"
>
  Próximo
</Button>

// Somente ícone
<Button 
  icon={<i className="ri-settings-line" />}
  iconOnly
  title="Configurações"
/>`}</pre>
            </div>
          </div>
        </div>
      </section>

      {/* 3. Variantes e Tamanhos */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">3. Variantes e Tamanhos</h2>
          <p className="text-muted-foreground">
            Combine ícones com diferentes variantes e tamanhos de botão
          </p>
        </div>

        <div className="space-y-6">
          {/* Variantes */}
          <div>
            <h3 className="font-medium mb-3">Diferentes Variantes:</h3>
            <div className="flex flex-wrap gap-3">
              <Button variant="default" icon={<i className="ri-heart-line" />}>Default</Button>
              <Button variant="destructive" icon={<i className="ri-delete-bin-line" />}>Delete</Button>
              <Button variant="outline" icon={<i className="ri-edit-line" />}>Edit</Button>
              <Button variant="secondary" icon={<i className="ri-download-line" />}>Download</Button>
              <Button variant="ghost" icon={<i className="ri-share-line" />}>Share</Button>
              <Button variant="link" icon={<i className="ri-external-link-line" />}>Link</Button>
            </div>
          </div>

          {/* Tamanhos */}
          <div>
            <h3 className="font-medium mb-3">Diferentes Tamanhos:</h3>
            <div className="flex items-center gap-3">
              <Button size="sm" icon={<i className="ri-star-line" />}>Small</Button>
              <Button size="default" icon={<i className="ri-star-line" />}>Default</Button>
              <Button size="lg" icon={<i className="ri-star-line" />}>Large</Button>
            </div>
          </div>

          {/* Botões de ícone só */}
          <div>
            <h3 className="font-medium mb-3">Somente Ícones:</h3>
            <div className="flex items-center gap-2">
              <Button size="sm" icon={<i className="ri-heart-line" />} iconOnly title="Curtir" />
              <Button size="default" icon={<i className="ri-share-line" />} iconOnly title="Compartilhar" />
              <Button size="lg" icon={<i className="ri-bookmark-line" />} iconOnly title="Salvar" />
            </div>
          </div>
        </div>
      </section>

      {/* 4. Casos de Uso Práticos */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">4. Casos de Uso no Seu Sistema</h2>
          <p className="text-muted-foreground">
            Exemplos práticos para diferentes páginas do sistema
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-6">
          {/* WhatsApp Actions */}
          <div className="p-4 border rounded-lg space-y-3">
            <h3 className="font-medium text-green-600">📱 Ações WhatsApp</h3>
            <div className="space-y-2">
              <Button className="w-full" icon={<i className="ri-message-line" />}>
                Nova Mensagem
              </Button>
              <Button className="w-full" variant="outline" icon={<i className="ri-calendar-schedule-line" />}>
                Agendar Mensagem
              </Button>
              <Button className="w-full" variant="secondary" icon={<i className="ri-repeat-line" />}>
                Mensagem Recorrente
              </Button>
            </div>
          </div>

          {/* Admin Actions */}
          <div className="p-4 border rounded-lg space-y-3">
            <h3 className="font-medium text-blue-600">⚙️ Ações Admin</h3>
            <div className="space-y-2">
              <Button className="w-full" icon={<i className="ri-user-add-line" />}>
                Adicionar Usuário
              </Button>
              <Button className="w-full" variant="outline" icon={<i className="ri-settings-line" />}>
                Configurações
              </Button>
              <Button className="w-full" variant="destructive" icon={<i className="ri-logout-box-line" />}>
                Fazer Logout
              </Button>
            </div>
          </div>

          {/* File Actions */}
          <div className="p-4 border rounded-lg space-y-3">
            <h3 className="font-medium text-purple-600">📁 Ações de Arquivo</h3>
            <div className="space-y-2">
              <Button className="w-full" variant="outline" icon={<i className="ri-upload-line" />}>
                Upload
              </Button>
              <Button className="w-full" variant="outline" icon={<i className="ri-download-line" />}>
                Download
              </Button>
              <Button className="w-full" variant="ghost" icon={<i className="ri-file-copy-line" />}>
                Duplicar
              </Button>
            </div>
          </div>

          {/* Status Actions */}
          <div className="p-4 border rounded-lg space-y-3">
            <h3 className="font-medium text-orange-600">📊 Status e Relatórios</h3>
            <div className="space-y-2">
              <Button className="w-full" variant="outline" icon={<i className="ri-bar-chart-line" />}>
                Ver Relatórios
              </Button>
              <Button className="w-full" variant="outline" icon={<i className="ri-refresh-line" />}>
                Atualizar Dados
              </Button>
              <Button className="w-full" variant="ghost" icon={<i className="ri-eye-line" />}>
                Visualizar
              </Button>
            </div>
          </div>
        </div>
      </section>

      {/* 5. Toolbar Example */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">5. Exemplo de Toolbar</h2>
          <p className="text-muted-foreground">
            Como criar uma barra de ferramentas com botões de ícone
          </p>
        </div>

        <div className="p-4 bg-muted rounded-lg">
          <div className="flex gap-1 w-fit">
            <Button icon={<i className="ri-bold" />} iconOnly variant="ghost" size="sm" title="Negrito" />
            <Button icon={<i className="ri-italic" />} iconOnly variant="ghost" size="sm" title="Itálico" />
            <Button icon={<i className="ri-underline" />} iconOnly variant="ghost" size="sm" title="Sublinhado" />
            
            <div className="w-px bg-border mx-2" />
            
            <Button icon={<i className="ri-align-left" />} iconOnly variant="ghost" size="sm" title="Esquerda" />
            <Button icon={<i className="ri-align-center" />} iconOnly variant="ghost" size="sm" title="Centro" />
            <Button icon={<i className="ri-align-right" />} iconOnly variant="ghost" size="sm" title="Direita" />
          </div>
        </div>

        <div className="bg-slate-100 dark:bg-slate-800 p-4 rounded-lg text-sm">
          <pre>{`<div className="flex gap-1">
  <Button icon={<i className="ri-bold" />} iconOnly variant="ghost" size="sm" title="Negrito" />
  <Button icon={<i className="ri-italic" />} iconOnly variant="ghost" size="sm" title="Itálico" />
  {/* ... mais botões ... */}
</div>`}</pre>
        </div>
      </section>

      {/* 6. Estados Especiais */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">6. Estados Especiais</h2>
          <p className="text-muted-foreground">
            Ícones para diferentes estados da aplicação
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-4">
          <div className="space-y-3">
            <h3 className="font-medium">Loading:</h3>
            <Button icon={<i className="ri-loader-4-line animate-spin" />} disabled>
              Carregando...
            </Button>
          </div>

          <div className="space-y-3">
            <h3 className="font-medium">Sucesso:</h3>
            <Button 
              icon={<i className="ri-check-line" />} 
              variant="outline"
              className="text-green-600 border-green-600 hover:bg-green-50"
            >
              Concluído
            </Button>
          </div>

          <div className="space-y-3">
            <h3 className="font-medium">Erro:</h3>
            <Button icon={<i className="ri-error-warning-line" />} variant="destructive">
              Erro
            </Button>
          </div>
        </div>
      </section>

      {/* 7. Dicas Importantes */}
      <section className="space-y-6">
        <div className="space-y-2">
          <h2 className="text-2xl font-semibold">7. Dicas Importantes</h2>
        </div>

        <div className="grid md:grid-cols-2 gap-6">
          <div className="p-4 bg-blue-50 dark:bg-blue-950 rounded-lg">
            <h3 className="font-medium text-blue-700 dark:text-blue-300 mb-2">✅ Boas Práticas</h3>
            <ul className="text-sm space-y-1 text-blue-600 dark:text-blue-400">
              <li>• Use ícones que fazem sentido contextual</li>
              <li>• Sempre adicione <code>title</code> em botões iconOnly</li>
              <li>• Mantenha consistência de ícones no projeto</li>
              <li>• Use animações com moderação (como spin)</li>
            </ul>
          </div>

          <div className="p-4 bg-amber-50 dark:bg-amber-950 rounded-lg">
            <h3 className="font-medium text-amber-700 dark:text-amber-300 mb-2">⚠️ Evite</h3>
            <ul className="text-sm space-y-1 text-amber-600 dark:text-amber-400">
              <li>• Ícones muito pequenos em botões pequenos</li>
              <li>• Misturar diferentes bibliotecas de ícones</li>
              <li>• Ícones que não representam a ação</li>
              <li>• Botões iconOnly sem título/tooltip</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Call to Action */}
      <div className="text-center p-8 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-950 dark:to-purple-950 rounded-lg">
        <h3 className="text-xl font-semibold mb-2">Pronto para Começar?</h3>
        <p className="text-muted-foreground mb-4">
          Agora você pode usar ícones em qualquer botão do seu sistema!
        </p>
        <Button icon={<i className="ri-rocket-line" />} size="lg">
          Implementar no Projeto
        </Button>
      </div>
    </div>
  );
}

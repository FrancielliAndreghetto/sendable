// Exemplo de configuração customizada em tempo real
'use client'

import { ConfigurableDialog, type DialogConfig } from '@/components/dialogs/ConfigurableDialog'
import { useState } from 'react'

export function CustomDialogExample() {
  const [isLoading, setIsLoading] = useState(false)

  // Configuração dinâmica baseada em condições
  const createDynamicConfig = (): DialogConfig => {
    const isAdvancedMode = true // Pode vir de um estado ou prop

    const baseFields = [
      {
        name: 'title',
        label: 'Título',
        type: 'text' as const,
        placeholder: 'Digite o título',
        required: true
      },
      {
        name: 'description',
        label: 'Descrição',
        type: 'textarea' as const,
        placeholder: 'Digite a descrição'
      }
    ]

    // Adiciona campos extras no modo avançado
    const advancedFields = [
      {
        name: 'category',
        label: 'Categoria',
        type: 'text' as const,
        placeholder: 'Categoria do item'
      },
      {
        name: 'priority',
        label: 'Prioridade',
        type: 'text' as const,
        placeholder: 'Alta, Média, Baixa'
      }
    ]

    return {
      title: isAdvancedMode ? 'Criar Item (Modo Avançado)' : 'Criar Item',
      description: 'Configure os detalhes do item',
      triggerLabel: 'Novo Item',
      submitLabel: 'Criar',
      fields: isAdvancedMode ? [...baseFields, ...advancedFields] : baseFields
    }
  }

  const handleSubmit = async (data: Record<string, string>) => {
    setIsLoading(true)
    try {
      console.log('Dados do formulário:', data)
      await new Promise(resolve => setTimeout(resolve, 1000))
      alert('Item criado com sucesso!')
    } catch {
      alert('Erro ao criar item')
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-6">Dialog Configurável Dinamicamente</h1>
      
      <div className="space-y-4">
        <ConfigurableDialog 
          config={createDynamicConfig()}
          onSubmit={handleSubmit}
          isLoading={isLoading}
        />
        
        <p className="text-sm text-gray-600">
          Este dialog muda seus campos baseado na configuração dinâmica.
        </p>
      </div>
    </div>
  )
}

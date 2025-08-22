import { useState } from 'react'

// Hook customizado para gerenciar loading states e handlers
export function useDialogHandlers() {
  const [isLoading, setIsLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)

  const createHandler = (apiCall: (data: Record<string, string>) => Promise<unknown>) => {
    return async (data: Record<string, string>) => {
      setIsLoading(true)
      setError(null)
      
      try {
        await apiCall(data)
        // Success - você pode adicionar notificação de sucesso aqui
        console.log('Operação realizada com sucesso!')
      } catch (err) {
        const errorMessage = err instanceof Error ? err.message : 'Erro desconhecido'
        setError(errorMessage)
        console.error('Erro na operação:', errorMessage)
      } finally {
        setIsLoading(false)
      }
    }
  }

  return {
    isLoading,
    error,
    createHandler,
    clearError: () => setError(null)
  }
}

// Simulação de APIs (substitua pelas suas APIs reais)
export const messageAPI = {
  create: async (data: Record<string, string>) => {
    // Simula delay da API
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    // Simula erro ocasional para teste
    if (Math.random() < 0.1) {
      throw new Error('Erro ao criar mensagem')
    }
    
    console.log('Mensagem criada:', data)
    return { id: Date.now(), ...data }
  },

  update: async (id: string, data: Record<string, string>) => {
    await new Promise(resolve => setTimeout(resolve, 1000))
    
    if (Math.random() < 0.1) {
      throw new Error('Erro ao atualizar mensagem')
    }
    
    console.log('Mensagem atualizada:', { id, ...data })
    return { id, ...data }
  },

  delete: async (id: string) => {
    await new Promise(resolve => setTimeout(resolve, 800))
    
    if (Math.random() < 0.1) {
      throw new Error('Erro ao deletar mensagem')
    }
    
    console.log('Mensagem deletada:', id)
    return { success: true }
  }
}

export const contactAPI = {
  create: async (data: Record<string, string>) => {
    await new Promise(resolve => setTimeout(resolve, 1200))
    
    if (Math.random() < 0.1) {
      throw new Error('Erro ao criar contato')
    }
    
    console.log('Contato criado:', data)
    return { id: Date.now(), ...data }
  },

  update: async (id: string, data: Record<string, string>) => {
    await new Promise(resolve => setTimeout(resolve, 1000))
    
    if (Math.random() < 0.1) {
      throw new Error('Erro ao atualizar contato')
    }
    
    console.log('Contato atualizado:', { id, ...data })
    return { id, ...data }
  }
}

export const instanceAPI = {
  create: async (data: Record<string, string>) => {
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    if (Math.random() < 0.1) {
      throw new Error('Erro ao criar instância')
    }
    
    console.log('Instância criada:', data)
    return { id: Date.now(), ...data }
  }
}

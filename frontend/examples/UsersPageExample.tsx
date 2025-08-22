// Exemplo de uso na página de usuários
'use client'

import { ConfigurableDialog, DIALOG_CONFIGS } from '@/components/dialogs/ConfigurableDialog'
import { useState } from 'react'

export function UsersPage() {
  const [isLoading, setIsLoading] = useState(false)

  const handleCreateUser = async (data: Record<string, string>) => {
    setIsLoading(true)
    try {
      console.log('Criando usuário:', data)
      await new Promise(resolve => setTimeout(resolve, 1500))
      
      // Aqui você faria a chamada real para a API
      // await createUser(data)
      
      alert('Usuário criado com sucesso!')
    } catch {
      alert('Erro ao criar usuário')
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-bold">Usuários</h1>
        <ConfigurableDialog 
          config={DIALOG_CONFIGS.user}
          onSubmit={handleCreateUser}
          isLoading={isLoading}
        />
      </div>
      
      {/* Lista de usuários aqui */}
      <div className="space-y-2">
        <p>Lista de usuários...</p>
      </div>
    </div>
  )
}

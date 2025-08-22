// Exemplo de uso na página de contatos
'use client'

import { ConfigurableDialog, DIALOG_CONFIGS } from '@/components/dialogs/ConfigurableDialog'
import { useState } from 'react'

export function ContactsPage() {
  const [isLoading, setIsLoading] = useState(false)

  const handleCreateContact = async (data: Record<string, string>) => {
    setIsLoading(true)
    try {
      // Simula chamada para API
      console.log('Criando contato:', data)
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      // Aqui você faria a chamada real para a API
      // await createContact(data)
      
      alert('Contato criado com sucesso!')
    } catch {
      alert('Erro ao criar contato')
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-bold">Contatos</h1>
        <ConfigurableDialog 
          config={DIALOG_CONFIGS.contact}
          onSubmit={handleCreateContact}
          isLoading={isLoading}
        />
      </div>
      
      {/* Lista de contatos aqui */}
      <div className="space-y-2">
        <p>Lista de contatos...</p>
      </div>
    </div>
  )
}

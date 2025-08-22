import type { DialogConfig } from '@/components/dialogs/ConfigurableDialog'

// Configurações específicas para mensagens
export const MESSAGE_DIALOG_CONFIGS = {
  // Dialog para criar nova mensagem (versão simples)
  createSimple: {
    title: 'Nova Mensagem',
    description: 'Envie uma mensagem via WhatsApp',
    triggerLabel: 'Nova Mensagem',
    submitLabel: 'Enviar',
    fields: [
      {
        name: 'contact',
        label: 'Contato',
        type: 'text' as const,
        placeholder: 'Nome ou número do contato',
        required: true
      },
      {
        name: 'message',
        label: 'Mensagem',
        type: 'textarea' as const,
        placeholder: 'Digite sua mensagem...',
        required: true
      }
    ]
  },

  // Dialog para criar mensagem com agendamento
  createScheduled: {
    title: 'Nova Mensagem Agendada',
    description: 'Agende uma mensagem para ser enviada posteriormente',
    triggerLabel: 'Agendar Mensagem',
    submitLabel: 'Agendar',
    fields: [
      {
        name: 'contact',
        label: 'Contato',
        type: 'text' as const,
        placeholder: 'Nome ou número do contato',
        required: true
      },
      {
        name: 'message',
        label: 'Mensagem',
        type: 'textarea' as const,
        placeholder: 'Digite sua mensagem...',
        required: true
      },
      {
        name: 'scheduled_date',
        label: 'Data/Hora',
        type: 'text' as const,
        placeholder: '2024-12-25 14:30',
        required: true
      }
    ]
  },

  // Dialog para mensagem recorrente
  createRecurring: {
    title: 'Mensagem Recorrente',
    description: 'Configure uma mensagem para ser enviada periodicamente',
    triggerLabel: 'Mensagem Recorrente',
    submitLabel: 'Configurar',
    fields: [
      {
        name: 'contact',
        label: 'Contato',
        type: 'text' as const,
        placeholder: 'Nome ou número do contato',
        required: true
      },
      {
        name: 'message',
        label: 'Mensagem',
        type: 'textarea' as const,
        placeholder: 'Digite sua mensagem...',
        required: true
      },
      {
        name: 'scheduled_date',
        label: 'Primeira Execução',
        type: 'text' as const,
        placeholder: '2024-12-25 14:30',
        required: true
      },
      {
        name: 'recurrence_type',
        label: 'Tipo de Recorrência',
        type: 'text' as const,
        placeholder: 'daily, weekly, monthly...',
        required: true
      },
      {
        name: 'recurrence_interval',
        label: 'Intervalo',
        type: 'text' as const,
        placeholder: 'Ex: 2 (a cada 2 semanas)',
        defaultValue: '1'
      }
    ]
  },

  // Dialog para editar mensagem
  edit: {
    title: 'Editar Mensagem',
    description: 'Modifique os dados da mensagem',
    triggerLabel: 'Editar',
    submitLabel: 'Salvar',
    fields: [
      {
        name: 'contact',
        label: 'Contato',
        type: 'text' as const,
        placeholder: 'Nome ou número do contato'
      },
      {
        name: 'message',
        label: 'Mensagem',
        type: 'textarea' as const,
        placeholder: 'Digite sua mensagem...'
      },
      {
        name: 'scheduled_date',
        label: 'Data/Hora',
        type: 'text' as const,
        placeholder: '2024-12-25 14:30'
      }
    ]
  }
} satisfies Record<string, DialogConfig>

'use client'

import { useState } from 'react'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

// Tipos para configuração dos campos
export interface FieldConfig {
  name: string
  label: string
  type?: 'text' | 'email' | 'password' | 'textarea'
  placeholder?: string
  required?: boolean
  defaultValue?: string
}

export interface DialogConfig {
  title: string
  description?: string
  fields: FieldConfig[]
  submitLabel?: string
  triggerLabel: string
  triggerIcon?: React.ReactNode
  triggerVariant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link'
}

interface ConfigurableDialogProps {
  config: DialogConfig
  onSubmit: (data: Record<string, string>) => void | Promise<void>
  isLoading?: boolean
}

export function ConfigurableDialog({ config, onSubmit, isLoading = false }: ConfigurableDialogProps) {
  const [open, setOpen] = useState(false)
  const [formData, setFormData] = useState<Record<string, string>>(() => {
    // Inicializa com valores padrão
    const initialData: Record<string, string> = {}
    config.fields.forEach(field => {
      initialData[field.name] = field.defaultValue || ''
    })
    return initialData
  })

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    
    try {
      await onSubmit(formData)
      setOpen(false)
      // Reset form after success
      const resetData: Record<string, string> = {}
      config.fields.forEach(field => {
        resetData[field.name] = field.defaultValue || ''
      })
      setFormData(resetData)
    } catch (error) {
      console.error('Error submitting form:', error)
    }
  }

  const handleFieldChange = (fieldName: string, value: string) => {
    setFormData(prev => ({
      ...prev,
      [fieldName]: value
    }))
  }

  const renderField = (field: FieldConfig) => {
    const commonProps = {
      id: field.name,
      value: formData[field.name] || '',
      onChange: (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => 
        handleFieldChange(field.name, e.target.value),
      placeholder: field.placeholder,
      required: field.required,
      disabled: isLoading
    }

    return (
      <div key={field.name} className="grid grid-cols-4 items-center gap-4">
        <Label htmlFor={field.name} className="text-right">
          {field.label}
          {field.required && <span className="text-red-500 ml-1">*</span>}
        </Label>
        <div className="col-span-3">
          {field.type === 'textarea' ? (
            <textarea
              {...commonProps}
              className="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
            />
          ) : (
            <Input
              {...commonProps}
              type={field.type || 'text'}
            />
          )}
        </div>
      </div>
    )
  }

  return (
    <Dialog open={open} onOpenChange={setOpen}>
      <DialogTrigger asChild>
        <Button 
          variant={config.triggerVariant || "outline"}
          icon={config.triggerIcon}
        >
          {config.triggerLabel}
        </Button>
      </DialogTrigger>
      <DialogContent className="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>{config.title}</DialogTitle>
          {config.description && (
            <DialogDescription>{config.description}</DialogDescription>
          )}
        </DialogHeader>
        <form onSubmit={handleSubmit}>
          <div className="grid gap-4 py-4">
            {config.fields.map(renderField)}
          </div>
          <DialogFooter>
            <Button type="button" variant="outline" onClick={() => setOpen(false)} disabled={isLoading}>
              Cancelar
            </Button>
            <Button type="submit" disabled={isLoading}>
              {isLoading ? 'Salvando...' : (config.submitLabel || 'Salvar')}
            </Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  )
}

// Exemplos de configurações pré-definidas
export const DIALOG_CONFIGS = {
  // Para página de contatos (2 campos)
  contact: {
    title: 'Novo Contato',
    description: 'Adicione um novo contato à sua lista',
    triggerLabel: 'Adicionar Contato',
    submitLabel: 'Criar Contato',
    fields: [
      {
        name: 'name',
        label: 'Nome',
        type: 'text' as const,
        placeholder: 'Digite o nome do contato',
        required: true
      },
      {
        name: 'phone',
        label: 'Telefone',
        type: 'text' as const,
        placeholder: '(11) 99999-9999',
        required: true
      }
    ]
  },

  // Para página de usuários (3 campos)
  user: {
    title: 'Novo Usuário',
    description: 'Crie uma nova conta de usuário',
    triggerLabel: 'Adicionar Usuário',
    submitLabel: 'Criar Usuário',
    fields: [
      {
        name: 'name',
        label: 'Nome',
        type: 'text' as const,
        placeholder: 'Digite o nome completo',
        required: true
      },
      {
        name: 'email',
        label: 'Email',
        type: 'email' as const,
        placeholder: 'usuario@exemplo.com',
        required: true
      },
      {
        name: 'password',
        label: 'Senha',
        type: 'password' as const,
        placeholder: 'Digite uma senha segura',
        required: true
      }
    ]
  },

  // Para instâncias WhatsApp (4 campos)
  whatsappInstance: {
    title: 'Nova Instância WhatsApp',
    description: 'Configure uma nova instância do WhatsApp',
    triggerLabel: 'Criar Instância',
    submitLabel: 'Criar Instância',
    fields: [
      {
        name: 'name',
        label: 'Nome',
        type: 'text' as const,
        placeholder: 'Nome da instância',
        required: true
      },
      {
        name: 'phone',
        label: 'Telefone',
        type: 'text' as const,
        placeholder: '5511999999999',
        required: true
      },
      {
        name: 'token',
        label: 'Token',
        type: 'text' as const,
        placeholder: 'Token opcional'
      },
      {
        name: 'description',
        label: 'Descrição',
        type: 'textarea' as const,
        placeholder: 'Descrição da instância'
      }
    ]
  }
}

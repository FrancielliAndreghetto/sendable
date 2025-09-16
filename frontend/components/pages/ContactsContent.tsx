'use client'

import { RiDeleteBinLine, RiPencilLine, RiUserFollowLine } from "@remixicon/react";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import useGetContacts from "@/hooks/api/user/useGetContacts";
import useDeleteContact from "@/hooks/api/user/useDeleteContact";
import { IContact, IInstance } from "@/types";
import useAuthUser from "@/hooks/store/auth/useAuthUser";
import { useState } from "react";
import useCreateContact from "@/hooks/api/user/useCreateContact";
import useGetInstances from "@/hooks/api/user/useGetInstances";
import useUpdateContact from "@/hooks/api/user/useUpdateContact";
import CustomInput from "@/components/forms/elements/CustomInput";

export function ContactsContent() {
  const { data, isLoading, error, refetch } = useGetContacts();
  const { data: instancesData, isLoading: isLoadingInstances } = useGetInstances();
  const { mutate: deleteContact, isPending: isDeleting } = useDeleteContact();
  const { mutate: createContact, status: createStatus } = useCreateContact();
  const { mutate: updateContact, status: updateStatus } = useUpdateContact();
  const { isAuthenticated, isHydrated } = useAuthUser();
  const isCreating = createStatus === "pending";
  const isUpdating = updateStatus === "pending";

  const [createOpen, setCreateOpen] = useState(false);
  const [editOpen, setEditOpen] = useState(false);
  const [selectedContact, setSelectedContact] = useState<IContact | null>(null);
  const [nameField, setNameField] = useState("");
  const [numberField, setNumberField] = useState("");
  const [instanceIdField, setInstanceIdField] = useState("");

    const openCreateModal = () => {
      setNameField("");
      setNumberField("");
      setInstanceIdField("");
      setCreateOpen(true);
    };

    const submitCreate = async () => {
    if (!nameField || !numberField) {
      alert("Nome e número são obrigatórios");
      return;
    }
    // usar o hook de criação
    createContact(
      { name: nameField, number: numberField, instance_id: instanceIdField || undefined },
      {
        onSuccess: () => {
          setCreateOpen(false);
          setNameField("");
          setNumberField("");
          setInstanceIdField("");
          refetch();
        },
        onError: (err) => {
          console.error("Erro ao criar contato:", err);
          alert("Erro ao criar contato");
        },
      },
    );
  };

  const handleDeleteContact = (contactId: string) => {
    if (confirm('Deseja realmente deletar este contato?')) {
      deleteContact(contactId, {
        onSuccess: () => {
          refetch();
        },
      });
    }
  };

  const handleEditContact = (contact: IContact) => {
    setSelectedContact(contact);
    setNameField(contact.name);
    setNumberField(contact.number);
    setInstanceIdField(contact.instance_id || "");
    setEditOpen(true);
  };

  const submitEdit = () => {
    if (!selectedContact) return;
    updateContact(
      { 
        id: selectedContact.id!, 
        data: { name: nameField, number: numberField, instance_id: instanceIdField || undefined } 
      },
      {
        onSuccess: () => {
          setEditOpen(false);
          setSelectedContact(null);
          refetch();
        },
        onError: (err) => {
          console.error("Erro ao atualizar contato:", err);
          alert("Erro ao atualizar contato");
        },
      },
    );
  };

  if (isLoading || isLoadingInstances) {
    return (
      <div className="p-6">
        <div className="flex items-center justify-center h-64">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="p-6">
        <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
          Erro ao carregar contatos: {error.message}
          <br />
          <small>Auth: {isAuthenticated ? 'Logado' : 'Não logado'}</small>
        </div>
      </div>
    );
  }

  const contacts = data?.data || [];
  const instances = instancesData?.data || [];

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <div className="flex items-center gap-2">
          <RiUserFollowLine size={22} className="text-muted-foreground" />
          <h1 className="text-2xl font-bold">Contatos</h1>
        </div>
        <Button onClick={openCreateModal}>
          Novo contato
        </Button>
      </div>

      {/* Create modal */}
      {createOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" onClick={() => setCreateOpen(false)} />
          <div className="relative z-50 w-full max-w-md p-6">
            <div className="bg-background dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold">Criar Contato</h3>
                <div className="space-y-4 my-6">
                  <CustomInput
                    label="Nome"
                    value={nameField}
                    onChange={(e) => setNameField(e.target.value)}
                    placeholder="Nome do contato"
                  />
                  <CustomInput
                    label="Telefone"
                    value={numberField}
                    onChange={(e) => setNumberField(e.target.value)}
                    placeholder="Número de telefone"
                  />
                  <div className="grid w-full items-center gap-1.5">
                    <label className="text-sm font-medium leading-none">Instância (opcional)</label>
                    <select
                      className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      value={instanceIdField}
                      onChange={(e) => setInstanceIdField(e.target.value)}
                    >
                      <option value="">Nenhuma</option>
                      {instances.map((instance: IInstance) => (
                        <option key={instance.id} value={instance.id!}>{instance.name}</option>
                      ))}
                    </select>
                  </div>
                </div>
                <div className="flex justify-end gap-2">
                  <Button variant="ghost" onClick={() => setCreateOpen(false)}>Cancelar</Button>
                  <Button onClick={submitCreate} disabled={isCreating}>{isCreating ? "Criando..." : "Criar"}</Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Edit modal */}
      {editOpen && selectedContact && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" onClick={() => setEditOpen(false)} />
          <div className="relative z-50 w-full max-w-md p-6">
            <div className="bg-background dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold">Editar Contato</h3>
                <div className="space-y-4 my-6">
                  <CustomInput
                    label="Nome"
                    value={nameField}
                    onChange={(e) => setNameField(e.target.value)}
                    placeholder="Nome do contato"
                  />
                  <CustomInput
                    label="Telefone"
                    value={numberField}
                    onChange={(e) => setNumberField(e.target.value)}
                    placeholder="Número de telefone"
                  />
                  <div className="grid w-full items-center gap-1.5">
                    <label className="text-sm font-medium leading-none">Instância (opcional)</label>
                    <select
                      className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                      value={instanceIdField}
                      onChange={(e) => setInstanceIdField(e.target.value)}
                    >
                      <option value="">Nenhuma</option>
                      {instances.map((instance: IInstance) => (
                        <option key={instance.id} value={instance.id!}>{instance.name}</option>
                      ))}
                    </select>
                  </div>
                </div>
                <div className="flex justify-end gap-2">
                  <Button variant="ghost" onClick={() => setEditOpen(false)}>Cancelar</Button>
                  <Button onClick={submitEdit} disabled={isUpdating}>{isUpdating ? "Salvando..." : "Salvar"}</Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {contacts.length === 0 ? (
        <div className="text-center py-12 text-muted-foreground">
          Nenhum contato encontrado
        </div>
      ) : (
        <div className="border rounded-lg">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nome</TableHead>
                <TableHead>Telefone</TableHead>
                <TableHead>Instância</TableHead>
                <TableHead>Criado em</TableHead>
                <TableHead className="text-right">Ações</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {contacts.map((contact) => (
                <TableRow key={contact.id}>
                  <TableCell className="font-medium">{contact.name}</TableCell>
                  <TableCell>{contact.number}</TableCell>
                  <TableCell>
                    {instances.find((instance: IInstance) => instance.id === contact.instance_id)?.name || '-'}
                  </TableCell>
                  <TableCell>{contact.created_at ? new Date(contact.created_at).toLocaleDateString("pt-BR") : "-"}</TableCell>
                  <TableCell className="text-right">
                    <div className="flex gap-2 justify-end">
                      <Button 
                        variant="outline" 
                        size="sm"
                        onClick={() => handleEditContact(contact)}
                        disabled={isDeleting || isUpdating}
                      >
                        <RiPencilLine className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="destructive" 
                        size="sm"
                        onClick={() => handleDeleteContact(contact.id!)}
                        disabled={isDeleting || isUpdating}
                      >
                        <RiDeleteBinLine className="h-4 w-4" />
                      </Button>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </div>
      )}
    </div>
  );
}

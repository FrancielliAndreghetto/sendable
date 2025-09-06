'use client'

import { RiInstanceLine, RiDeleteBinLine, RiPencilLine } from "@remixicon/react";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import useGetInstances from "@/hooks/api/user/useGetInstances";
import useDeleteInstance from "@/hooks/api/user/useDeleteInstance";
import useUpdateInstance from "@/hooks/api/user/useUpdateInstance";
import useCreateInstance from "@/hooks/api/user/useCreateInstance";
import { useState } from "react";
import { IInstance } from "@/types";
import axios from "axios";
import { Tokens } from "@/types";

export function InstancesContent() {
  const { data, isLoading, error, refetch } = useGetInstances();
  const { mutate: deleteInstance, status: deleteStatus } = useDeleteInstance();
  const { mutate: updateInstance, status: updateStatus } = useUpdateInstance();
  const { mutate: createInstance, status: createStatus } = useCreateInstance();
  const isDeleting = deleteStatus === "pending";
  const isUpdating = updateStatus === "pending";
  const isCreating = createStatus === "pending";

  // modal states + form fields
  const [createOpen, setCreateOpen] = useState(false);
  const [editOpen, setEditOpen] = useState(false);
  const [deleteOpen, setDeleteOpen] = useState(false);
  const [selectedInstance, setSelectedInstance] = useState<IInstance | null>(null);
  const [nameField, setNameField] = useState("");
  const [numberField, setNumberField] = useState("");
  const [tokenField, setTokenField] = useState("");

  const handleDeleteInstance = (instanceId: string) => {
    // abrir modal de confirmação
    const inst = data?.data?.find((it: IInstance) => it.id === instanceId) ?? null;
    setSelectedInstance(inst);
    setDeleteOpen(true);
  };

  const confirmDelete = () => {
    if (!selectedInstance) return;
    deleteInstance(selectedInstance.id!, {
      onSuccess: () => {
        setDeleteOpen(false);
        setSelectedInstance(null);
        refetch();
      },
      onError: (err) => {
        console.error("Erro ao deletar instância:", err);
        alert("Erro ao deletar instância");
      },
    });
  };

  const handleEditInstance = (instance: IInstance) => {
    setSelectedInstance(instance);
    setNameField(instance.name ?? "");
    setNumberField((instance.whatsapp_number ?? instance.phone ?? "") as string);
    setTokenField((instance.token ?? "") as string);
    setEditOpen(true);
  };

  const submitEdit = () => {
    if (!selectedInstance) return;
    updateInstance(
      { id: selectedInstance.id!, data: { name: nameField, number: numberField } },
      {
        onSuccess: () => {
          setEditOpen(false);
          setSelectedInstance(null);
          refetch();
        },
        onError: (err) => {
          console.error("Erro ao atualizar instância:", err);
          alert("Erro ao atualizar instância");
        },
      },
    );
  };

  const openCreateModal = () => {
    setNameField("");
    setNumberField("");
    setTokenField("");
    setCreateOpen(true);
  };

  const submitCreate = async () => {
    // preferir usar hook createInstance
    if (!nameField || !numberField) {
      alert("Nome e número são obrigatórios");
      return;
    }
    // usar o hook de criação
    createInstance(
      { name: nameField, number: numberField, token: tokenField || undefined, platform: 'whatsapp' },
      {
        onSuccess: () => {
          setCreateOpen(false);
          setNameField("");
          setNumberField("");
          setTokenField("");
          refetch();
        },
        onError: (err) => {
          console.error("Erro ao criar instância:", err);
          alert("Erro ao criar instância");
        },
      },
    );
  };

  const getStatusVariant = (status: string) => {
    switch (status) {
      case 'connected': return 'default';
      case 'disconnected': return 'destructive';
      case 'connecting': return 'secondary';
      default: return 'secondary';
    }
  };

  const getStatusLabel = (status: string) => {
    switch (status) {
      case 'connected': return 'Conectada';
      case 'disconnected': return 'Desconectada';
      case 'connecting': return 'Conectando';
      default: return status;
    }
  };

  const getPlatformLabel = (platform: string) => {
    switch (platform) {
      case 'whatsapp': return 'WhatsApp';
      case 'telegram': return 'Telegram';
      case 'instagram': return 'Instagram';
      default: return platform;
    }
  };

  if (isLoading) {
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
          Erro ao carregar instâncias: {error.message}
        </div>
      </div>
    );
  }

  const instances = data?.data || [];

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <div className="flex items-center gap-2">
          <RiInstanceLine size={22} className="text-muted-foreground" />
          <h1 className="text-2xl font-bold">Instâncias</h1>
        </div>
        <Button onClick={openCreateModal}>
          Nova instância
        </Button>
      </div>

      {/* Create modal */}
      {createOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" onClick={() => setCreateOpen(false)} />
          <div className="relative z-50 w-full max-w-md p-6">
            <div className=" dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold mb-4">Criar Instância</h3>
                <label className="block text-sm mb-2">Nome</label>
                <input className="w-full border rounded px-3 py-2 mb-3 bg-transparent text-inherit" value={nameField} onChange={(e) => setNameField(e.target.value)} />
                <label className="block text-sm mb-2">Número</label>
                <input className="w-full border rounded px-3 py-2 mb-3 bg-transparent text-inherit" value={numberField} onChange={(e) => setNumberField(e.target.value)} />
                <label className="block text-sm mb-2">Token (opcional)</label>
                <input className="w-full border rounded px-3 py-2 mb-4 bg-transparent text-inherit" value={tokenField} onChange={(e) => setTokenField(e.target.value)} />
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
      {editOpen && selectedInstance && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" onClick={() => setEditOpen(false)} />
          <div className="relative z-50 w-full max-w-md p-6">
            <div className="dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold mb-4">Editar Instância</h3>
                <label className="block text-sm mb-2">Nome</label>
                <input className="w-full border rounded px-3 py-2 mb-3 bg-transparent text-inherit" value={nameField} onChange={(e) => setNameField(e.target.value)} />
                <label className="block text-sm mb-2">Número</label>
                <input className="w-full border rounded px-3 py-2 mb-4 bg-transparent text-inherit" value={numberField} onChange={(e) => setNumberField(e.target.value)} />
                <div className="flex justify-end gap-2">
                  <Button variant="ghost" onClick={() => { setEditOpen(false); setSelectedInstance(null); }}>Cancelar</Button>
                  <Button onClick={submitEdit} disabled={isUpdating}>{isUpdating ? "Salvando..." : "Salvar"}</Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Delete confirm modal */}
      {deleteOpen && selectedInstance && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" onClick={() => setDeleteOpen(false)} />
          <div className="relative z-50 w-full max-w-sm p-6">
            <div className="bg-white dark:bg-slate-900 dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold mb-2">Deletar Instância</h3>
                <p className="text-sm text-muted-foreground mb-4">Deseja realmente deletar a instância "<strong>{selectedInstance.name}</strong>"? Esta ação não pode ser desfeita.</p>
                <div className="flex justify-end gap-2">
                  <Button variant="ghost" onClick={() => { setDeleteOpen(false); setSelectedInstance(null); }}>Cancelar</Button>
                  <Button variant="destructive" onClick={confirmDelete} disabled={isDeleting}>{isDeleting ? "Deletando..." : "Deletar"}</Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {instances.length === 0 ? (
        <div className="text-center py-12 text-muted-foreground">
          Nenhuma instância encontrada
        </div>
      ) : (
        <div className="border rounded-lg">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nome</TableHead>
                <TableHead>Número</TableHead>
                <TableHead>Plataforma</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="text-right">Ações</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {instances.map((instance) => (
                <TableRow key={instance.id}>
                  <TableCell className="font-medium">{instance.name}</TableCell>
                  <TableCell>{instance.phone}</TableCell>
                  <TableCell>{getPlatformLabel(instance.platform)}</TableCell>
                  <TableCell>
                    <Badge variant={getStatusVariant(instance.status)}>
                      {getStatusLabel(instance.status)}
                    </Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex gap-2 justify-end">
                      <Button 
                        variant="outline" 
                        size="sm"
                        onClick={() => handleEditInstance(instance)}
                        disabled={isDeleting}
                      >
                        <RiPencilLine className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="destructive" 
                        size="sm"
                        onClick={() => handleDeleteInstance(instance.id!)}
                        disabled={isDeleting}
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


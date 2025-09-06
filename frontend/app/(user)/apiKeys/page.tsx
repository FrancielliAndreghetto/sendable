"use client";

import { useState } from "react";
import { useGetApiKeys } from "@/hooks/api/user/useGetApiKeys";
import LoadingOverlay from "@/components/LoadingOverlay";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { RiPencilLine, RiDeleteBinLine } from "@remixicon/react";
import useDeleteApiKey from "@/hooks/api/user/useDeleteApiKey";
import useUpdateApiKey from "@/hooks/api/user/useUpdateApiKey";

export default function Page() {
  const { data: apiKeysData, isLoading, error } = useGetApiKeys();
  const { mutate: deleteApiKey, status: deleteStatus } = useDeleteApiKey();
  const { mutate: updateApiKey, status: updateStatus } = useUpdateApiKey();
  const isDeleting = deleteStatus === "pending";
  const isUpdating = updateStatus === "pending";

  // modal states
  const [editOpen, setEditOpen] = useState(false);
  const [deleteOpen, setDeleteOpen] = useState(false);
  const [selectedKey, setSelectedKey] = useState<any | null>(null);
  const [editName, setEditName] = useState("");

  if (isLoading) {
    return <LoadingOverlay loading />;
  }

  if (error) {
    return (
      <div className="overflow-hidden px-4 md:px-6 lg:px-8">
        <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
          <div className="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            Erro ao carregar chaves de API: {error.message}
          </div>
        </div>
      </div>
    );
  }

  const apiKeys = apiKeysData?.data || [];

  // open modals
  const openEditModal = (apiKey: any) => {
    setSelectedKey(apiKey);
    setEditName(apiKey.name ?? "");
    setEditOpen(true);
  };

  const openDeleteModal = (apiKey: any) => {
    setSelectedKey(apiKey);
    setDeleteOpen(true);
  };

  // submit handlers using mutate callbacks to close modal on success
  const handleEditSubmit = () => {
    if (!selectedKey) return;
    updateApiKey(
      { id: selectedKey.id, data: { name: editName } },
      {
        onSuccess: () => {
          setEditOpen(false);
          setSelectedKey(null);
          setEditName("");
        },
      },
    );
  };

  const handleDeleteConfirm = () => {
    if (!selectedKey) return;
    deleteApiKey(selectedKey.id, {
      onSuccess: () => {
        setDeleteOpen(false);
        setSelectedKey(null);
      },
    });
  };

  return (
    <div className="overflow-hidden px-4 md:px-6 lg:px-8">
      <div className="flex flex-1 flex-col gap-4 lg:gap-6 py-4 lg:py-6">
        <div className="flex items-center justify-between gap-4">
          <div className="space-y-1">
            <h1 className="text-2xl font-semibold">Chaves de API</h1>
            <p className="text-sm text-muted-foreground">
              Visualize e gerencie suas chaves de API.
            </p>
          </div>
          <div>
            <button className="bg-gradient-to-r from-primary/40 to-primary/20 hover:from-primary/60 hover:to-primary/30 text-white font-bold py-2 px-4 rounded">
              Gerar nova chave de API
            </button>
          </div>
        </div>

        <div className="bg-gradient-to-b from-sidebar/60 to-sidebar p-3 rounded-2xl border border-border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nome</TableHead>
                <TableHead>Api Key</TableHead>
                <TableHead>Criado em</TableHead>
                <TableHead>Atualizado em</TableHead>
                <TableHead className="text-right">Ações</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {apiKeys.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={6} className="text-center text-muted-foreground py-8">
                    Nenhuma chave de API encontrada
                  </TableCell>
                </TableRow>
              ) : (
                apiKeys.map((apiKey: any) => (
                  <TableRow key={apiKey.id}>
                    <TableCell className="font-medium">{apiKey.name}</TableCell>
                    <TableCell className="font-mono text-sm">
                      {apiKey.key?.substring(0, 20) ?? ""}...
                    </TableCell>
                    <TableCell>
                      {apiKey.created_at ? new Date(apiKey.created_at).toLocaleDateString("pt-BR") : "-"}
                    </TableCell>
                    <TableCell>
                      {apiKey.updated_at ? new Date(apiKey.updated_at).toLocaleDateString("pt-BR") : "-"}
                    </TableCell>
                    <TableCell className="text-right">
                      <div className="flex gap-2 justify-end">
                        <Button
                          variant="outline"
                          className="cursor-pointer"
                          size="sm"
                          onClick={() => openEditModal(apiKey)}
                          disabled={isUpdating}
                        >
                          <RiPencilLine className="h-4 w-4" />
                        </Button>
                        <Button
                          variant="destructive"
                          className="cursor-pointer"
                          size="sm"
                          onClick={() => openDeleteModal(apiKey)}
                          disabled={isDeleting}
                        >
                          <RiDeleteBinLine className="h-4 w-4" />
                        </Button>
                      </div>
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </div>
      </div>

      {/* Edit modal */}
      {editOpen && selectedKey && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div
            className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
            onClick={() => setEditOpen(false)}
            aria-hidden
          />
          <div className="relative z-50 w-full max-w-md p-6">
            <div className="dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold mb-4">Editar Chave de API</h3>
                <label className="block text-sm mb-2">Nome</label>
                <input
                  className="w-full border rounded px-3 py-2 mb-4 bg-transparent text-inherit"
                  value={editName}
                  onChange={(e) => setEditName(e.target.value)}
                />
                <div className="flex justify-end gap-2 cursor-pointer">
                  <Button variant="ghost" onClick={() => { setEditOpen(false); setSelectedKey(null); }}>
                    Cancelar
                  </Button>
                  <Button className="cursor-pointer" onClick={handleEditSubmit} disabled={isUpdating}>
                    {isUpdating ? "Salvando..." : "Salvar"}
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Delete confirm modal */}
      {deleteOpen && selectedKey && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div
            className="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
            onClick={() => setDeleteOpen(false)}
            aria-hidden
          />
          <div className="relative z-50 w-full max-w-sm p-6">
            <div className=" dark:text-slate-100 rounded-lg shadow-xl overflow-hidden">
              <div className="p-6">
                <h3 className="text-lg font-semibold mb-2">Deletar Chave de API</h3>
                <p className="text-sm text-muted-foreground mb-4">
                  Deseja realmente deletar a chave "<strong>{selectedKey.name}</strong>"? Esta ação não pode ser desfeita.
                </p>
                <div className="flex justify-end gap-2 cursor-pointer">
                  <Button variant="ghost" onClick={() => { setDeleteOpen(false); setSelectedKey(null); }}>
                    Cancelar
                  </Button>
                  <Button className="cursor-pointer" variant="destructive" onClick={handleDeleteConfirm} disabled={isDeleting}>
                    {isDeleting ? "Deletando..." : "Deletar"}
                  </Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
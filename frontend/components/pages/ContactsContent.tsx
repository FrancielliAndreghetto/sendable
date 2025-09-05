'use client'

import { RiDeleteBinLine, RiPencilLine, RiUserFollowLine } from "@remixicon/react";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import useGetContacts from "@/hooks/api/user/useGetContacts";
import useDeleteContact from "@/hooks/api/user/useDeleteContact";
import { IContact } from "@/types";
import useAuthUser from "@/hooks/store/auth/useAuthUser";

export function ContactsContent() {
  const { data, isLoading, error, refetch } = useGetContacts();
  const { mutate: deleteContact, isPending: isDeleting } = useDeleteContact();
  const { isAuthenticated, isHydrated } = useAuthUser();

  console.log('Auth state:', { isAuthenticated, isHydrated });

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
    // TODO: Abrir modal de edição
    console.log('Editar contato:', contact);
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
          Erro ao carregar contatos: {error.message}
          <br />
          <small>Auth: {isAuthenticated ? 'Logado' : 'Não logado'}</small>
        </div>
      </div>
    );
  }

  const contacts = data?.data || [];

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <div className="flex items-center gap-2">
          <RiUserFollowLine size={22} className="text-muted-foreground" />
          <h1 className="text-2xl font-bold">Contatos</h1>
        </div>
        <Button>
          Novo contato
        </Button>
      </div>

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
                <TableHead>Email</TableHead>
                <TableHead>Tags</TableHead>
                <TableHead className="text-right">Ações</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {contacts.map((contact) => (
                <TableRow key={contact.id}>
                  <TableCell className="font-medium">{contact.name}</TableCell>
                  <TableCell>{contact.phone}</TableCell>
                  <TableCell>{contact.email || '-'}</TableCell>
                  <TableCell>
                    {contact.tags && contact.tags.length > 0 ? (
                      <div className="flex gap-1 flex-wrap">
                        {contact.tags.map((tag, index) => (
                          <Badge key={index} variant="secondary" className="text-xs">
                            {tag}
                          </Badge>
                        ))}
                      </div>
                    ) : (
                      '-'
                    )}
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex gap-2 justify-end">
                      <Button 
                        variant="outline" 
                        size="sm"
                        onClick={() => handleEditContact(contact)}
                        disabled={isDeleting}
                      >
                        <RiPencilLine className="h-4 w-4" />
                      </Button>
                      <Button 
                        variant="destructive" 
                        size="sm"
                        onClick={() => handleDeleteContact(contact.id!)}
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



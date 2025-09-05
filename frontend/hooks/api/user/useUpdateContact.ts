import { PUT } from "@/lib/api";
import { IContact } from "@/types";
import { PutRoutes } from "@/types/api/PutRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface UpdateContactData {
  name?: string;
  phone?: string;
  email?: string;
  tags?: string[];
}

interface UpdateContactResponse {
  contact: IContact;
}

const useUpdateContact = () => {
  const queryClient = useQueryClient();

  return useMutation<UpdateContactResponse, Error, { id: string; data: UpdateContactData }>({
    mutationFn: async ({ id, data }: { id: string; data: UpdateContactData }) => {
      const res = await PUT<UpdateContactResponse>({
        route: PutRoutes.UpdateContact,
        params: { id },
        body: data,
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetContacts] });
    },
  });
};

export default useUpdateContact;

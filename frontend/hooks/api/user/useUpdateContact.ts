import { PUT } from "@/lib/api";
import { IContact } from "@/types";
import { PutRoutes } from "@/types/api/PutRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface UpdateContactData {
  name?: string;
  number?: string;
  instance_id?: string;
}

interface UpdateContactParams {
  id: string;
  data: UpdateContactData;
}

interface UpdateContactResponse {
  contact: IContact;
}

const useUpdateContact = () => {
  const queryClient = useQueryClient();

  return useMutation<UpdateContactResponse, Error, UpdateContactParams>({
    mutationFn: async ({ id, data }: UpdateContactParams) => {
      return await PUT<UpdateContactResponse>({
        route: PutRoutes.UpdateContact,
        params: { contact: id },
        body: data,
      });
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetContacts] });
    },
  });
};

export default useUpdateContact;
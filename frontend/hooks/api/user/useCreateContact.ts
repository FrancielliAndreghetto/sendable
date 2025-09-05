import { POST } from "@/lib/api";
import { IContact } from "@/types";
import { PostRoutes } from "@/types/api/PostRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface CreateContactData {
  name: string;
  phone: string;
  email?: string;
  tags?: string[];
}

interface CreateContactResponse {
  contact: IContact;
}

const useCreateContact = () => {
  const queryClient = useQueryClient();

  return useMutation<CreateContactResponse, Error, CreateContactData>({
    mutationFn: async (data: CreateContactData) => {
      const res = await POST<CreateContactResponse>({
        route: PostRoutes.CreateContact,
        body: data,
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetContacts] });
    },
  });
};

export default useCreateContact;

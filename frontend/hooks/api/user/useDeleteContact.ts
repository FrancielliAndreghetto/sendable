import { DELETE } from "@/lib/api";
import { DeleteRoutes } from "@/types/api/DeleteRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface DeleteContactResponse {
  message: string;
}

const useDeleteContact = () => {
  const queryClient = useQueryClient();

  return useMutation<DeleteContactResponse, Error, string>({
    mutationFn: async (id: string) => {
      const res = await DELETE<DeleteContactResponse>({
        route: DeleteRoutes.DeleteContact,
        params: { id },
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetContacts] });
    },
  });
};

export default useDeleteContact;

import { DELETE } from "@/lib/api";
import { DeleteRoutes } from "@/types/api/DeleteRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface DeleteInstanceResponse {
  message: string;
}

const useDeleteInstance = () => {
  const queryClient = useQueryClient();

  return useMutation<DeleteInstanceResponse, Error, string>({
    mutationFn: async (id: string) => {
      const res = await DELETE<DeleteInstanceResponse>({
        route: DeleteRoutes.DeleteInstance,
        params: { id },
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetInstances] });
    },
  });
};

export default useDeleteInstance;

import { DELETE } from "@/lib/api";
import { DeleteRoutes } from "@/types/api/DeleteRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface DeleteApiKeyResponse {
  message: string;
}

const useDeleteApiKey = () => {
  const queryClient = useQueryClient();

  return useMutation<DeleteApiKeyResponse, Error, string>({
    mutationFn: async (id: string) => {
      const res = await DELETE<DeleteApiKeyResponse>({
        route: DeleteRoutes.DeleteApiKey,
        params: { id },
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetApiKeys] });
    },
  });
};

export default useDeleteApiKey;

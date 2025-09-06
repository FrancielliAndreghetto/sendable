import { PUT } from "@/lib/api";
import { PutRoutes } from "@/types/api/PutRoutes";
import { GetRoutes } from "@/types/api/GetRoutes";
import { useMutation, useQueryClient } from "@tanstack/react-query";

interface UpdateApiKeyData {
  name?: string;
  active?: boolean;
  scopes?: string[];
  expires_at?: string | null;
}

interface UpdateApiKeyResponse {
  data: any;
}

const useUpdateApiKey = () => {
  const queryClient = useQueryClient();

  return useMutation<UpdateApiKeyResponse, Error, { id: string; data: UpdateApiKeyData }>({
    mutationFn: async ({ id, data }: { id: string; data: UpdateApiKeyData }) => {
      const res = await PUT<UpdateApiKeyResponse>({
        route: PutRoutes.UpdateApiKey,
        params: { id },
        body: data,
      });
      return res;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: [GetRoutes.GetApiKeys] });
    },
  });
};

export default useUpdateApiKey;

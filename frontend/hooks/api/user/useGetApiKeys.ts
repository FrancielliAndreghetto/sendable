import { useQuery } from "@tanstack/react-query";
import { createApiInstance } from "@/lib/api/createApiInstance";
import { GetRoutes } from "@/types/api/GetRoutes";
import { IApiKey } from "@/types";

interface GetApiKeysResponse {
  data: IApiKey[];
  message: string;
  success: boolean;
}

export const useGetApiKeys = () => {
  return useQuery<GetApiKeysResponse>({
    queryKey: [GetRoutes.GetApiKeys],
    queryFn: async () => {
      const api = createApiInstance();
      const response = await api.get(GetRoutes.GetApiKeys);
      return response.data;
    },
  });
};

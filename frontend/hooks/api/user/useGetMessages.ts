import { useQuery } from "@tanstack/react-query";
import { createApiInstance } from "@/lib/api/createApiInstance";
import { GetRoutes } from "@/types/api/GetRoutes";
import { IMessage } from "@/types";

interface GetMessagesResponse {
  data: IMessage[];
  message: string;
  success: boolean;
}

export const useGetMessages = () => {
  return useQuery<GetMessagesResponse>({
    queryKey: [GetRoutes.GetMessages],
    queryFn: async () => {
      const api = createApiInstance();
      const response = await api.get(GetRoutes.GetMessages);
      return response.data;
    },
  });
};

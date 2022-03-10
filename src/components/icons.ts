/**
 * 自定义地图图标
 * @description 导出的是生成图标数据的函数，用法：`L.divIcon(iconname(size, fontcolor)(title))`
 */
export const MapIcon = {
  default:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/boss.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  cifu:
    (size: number = 20, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/fireicon.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  boss:
    (size: number = 30, fontcolor: string = 'yellow') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/boss.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  littleboss:
    (size: number = 28, fontcolor: string = 'yellow') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/littleboss.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  portal:
    (size: number = 24, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/portal.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  message:
    (size: number = 20, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/message.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  warning:
    (size: number = 15, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/warning.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  question:
    (size: number = 15, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/question.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  collect:
    (size: number = 20, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/collect.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  white:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/white.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  yellow:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/yellow.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  green:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/green.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  blue:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/blue.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  red:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/red.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
  purple:
    (size: number = 10, fontcolor: string = 'white') =>
    (title?: string, fontSize: string = '0.8em') => {
      return {
        iconUrl: './resource/icons/purple.png',
        iconSize: [size, size],
        iconAnchor: [size / 2, size / 2],
      };
    },
};
